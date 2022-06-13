<?php

namespace App\Message\MessageHandler;

use App\Entity\GridMessage as GridMessageEntity;
use App\Entity\MessageTransport;
use App\Enum\MessageTransportStatusEnum;
use App\Message\GridMessage;
use App\Repository\ApiResponseRepository;
use App\Repository\GridMessageRepository;
use App\Repository\MessageTransportRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GridMessageHandler implements MessageHandlerInterface {

    /**
     * @var ApiResponseRepository
     */
    private ApiResponseRepository $apiResponseRepository;

    /**
     * @var MessageTransportRepository
     */
    private MessageTransportRepository $messageTransportRepository;
    
    /**
     * @var GridMessageRepository
     */
    private GridMessageRepository $gridMessageRepository;

    public function __construct(
            ApiResponseRepository $apiResponseRepository,
            MessageTransportRepository $messageTransportRepository,
            GridMessageRepository $gridMessageRepository
    )
    {
        $this->apiResponseRepository = $apiResponseRepository;
        $this->messageTransportRepository = $messageTransportRepository;
        $this->gridMessageRepository = $gridMessageRepository;
    }

    /**
     * @param GridMessage $gridMessage
     */
    public function __invoke(GridMessage $gridMessage): void
    {
        echo 'Receiving grid message...';

        $messageTransport = $this->messageTransportRepository->findById($gridMessage->getTransportId());

        // Save the message to entity
        $gridMessageEntity = $this->createGridMessageEntityFromTransportAndGridMessageAndSave(
                $messageTransport,
                $gridMessage
        );
        
        // Update message transport with status received
        $messageTransport->setRoutingClassId($gridMessageEntity->getId());
        $messageTransport->setStatus(new MessageTransportStatusEnum(MessageTransportStatusEnum::RECEIVED));
        $this->messageTransportRepository->save($messageTransport);

        echo '...[Grid message entity with id #' . $gridMessageEntity->getId() . ']';
    }

    /**
     * @param MessageTransport $messageTransport
     * @param GridMessage $gridMessage
     * 
     * @return GridMessageEntity
     */
    private function createGridMessageEntityFromTransportAndGridMessageAndSave(
            MessageTransport $messageTransport,
            GridMessage $gridMessage
    ): GridMessageEntity {
       $gridMessageEntity = GridMessageEntity::createFromMessageTransportAndGridMessage(
                        $messageTransport,
                        $gridMessage
        );
        $this->gridMessageRepository->save($gridMessageEntity);

        return $gridMessageEntity;
    }
}
