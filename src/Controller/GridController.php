<?php

namespace App\Controller;

use App\Entity\MessageTransport;
use App\Enum\MessageTransportStatusEnum;
use App\Message\GridMessage;
use App\Objects\ApiGridObject;
use App\Objects\RoutingKey;
use App\Repository\MessageTransportRepository;
use App\Utility\ApiConnection\ApiConnectionNet2Grid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\SentStamp;

class GridController extends AbstractController {

    /**
     * Url to consume data from
     */
    const CONSUMPTION_URI = 'https://xqy1konaa2.execute-api.eu-west-1.amazonaws.com/prod/results';
    
    const MESSAGE_SUCCESS = 'Grid message has been placed';
    
    /**
     * @param MessageBusInterface $bus
     * @param ApiConnectionNet2Grid $apiConnectionNet2Grid
     * @param MessageTransportRepository $messageTransportRepository
     * 
     * @return Response
     */
    public function sendMessageAction(
            MessageBusInterface $bus,
            ApiConnectionNet2Grid $apiConnectionNet2Grid,
            MessageTransportRepository $messageTransportRepository
    ): Response {
        // Consume data from api
        $response = $apiConnectionNet2Grid->consumeMessageFromUrl(self::CONSUMPTION_URI);
        $responseBodyArray = ApiGridObject::toArrayFromJson($response->getResponseBody());

        $grid = ApiGridObject::createFromArray($responseBodyArray);

        // Save message transport with status pending
        $messageTransport = MessageTransport::create($response);
        $messageTransportRepository->save($messageTransport);

        // Dispatch
        $envelope = $this->createGridMessageAndDispatch($grid, $bus, $messageTransport);

        // Update message transport
        $this->updateMessageTransportWithEnvelopeAndSave(
                $messageTransport,
                $envelope,
                $messageTransportRepository
        );

        return $this->render('grid-messages/grid-message-index.html.twig', [
           'message' => self::MESSAGE_SUCCESS
        ]);
    }

    /**
     * @param MessageTransport $messageTransport
     * @param Envelope $envelope
     * @param MessageTransportRepository $messageTransportRepository
     * 
     * @return MessageTransport
     */
    private function updateMessageTransportWithEnvelopeAndSave(
            MessageTransport $messageTransport,
            Envelope $envelope,
            MessageTransportRepository $messageTransportRepository
    ): MessageTransport {
        $messageTransport->setTransport($envelope->all(SentStamp::class)[0]->getSenderClass());
        $messageTransport->setRoutingKey($envelope->all(AmqpStamp::class)[0]->getRoutingKey());
        $messageTransport->setRoutingClass($envelope->getMessage()::class);
        $messageTransport->setStatus(new MessageTransportStatusEnum(MessageTransportStatusEnum::SENT));
        $messageTransportRepository->save($messageTransport);

        return $messageTransport;
    }

    /**
     * @param ApiGridObject $gridObject
     * @param MessageBusInterface $bus
     * 
     * @return Envelope
     */
    private function createGridMessageAndDispatch(
            ApiGridObject $gridObject,
            MessageBusInterface $bus,
            MessageTransport $messageTransport
    ): Envelope {
        $gridMessage = new GridMessage(
                $gridObject->value,
                $gridObject->timestamp,
                $messageTransport->getId()
        );
        $gridMessageRoutingKey = RoutingKey::composeRoutingKeyFromApiGridObject($gridObject);

        return $bus->dispatch(
                $gridMessage,
                [new AmqpStamp($gridMessageRoutingKey, AMQP_NOPARAM)]
        );
    }
}
