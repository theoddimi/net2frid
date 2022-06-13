<?php

namespace App\Message\Serializer;

use App\Message\GridMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;

class GridJsonMessageSerializer implements SerializerInterface {

    /**
     * @param array $encodedEnvelope
     * 
     * @return Envelope
     * @throws MessageDecodingFailedException
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $data = json_decode($body, true);
        $message = new GridMessage($data['messageValue'], $data['timestamp'], $data['transportId']);

        if (null === $data) {
            throw new MessageDecodingFailedException('Invalid JSON');
        }

        // in case of redelivery, unserialize any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }

        $envelope = new Envelope($message);
        $envelope = $envelope->with(... $stamps);

        return $envelope;
    }

    /**
     * @param Envelope $envelope
     * 
     * @return array
     * @throws \Exception
     */
    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        if ($message instanceof GridMessage) {
            $data = [
                'messageValue' => $message->getMessageValue(),
                'timestamp' => $message->getTimestamp(),
                'transportId' => $message->getTransportId()
            ];
        } else {
            throw new \Exception('Unsupported message class');
        }

        $allStamps = [];
        foreach ($envelope->all() as $stamps) {
            $allStamps = array_merge($allStamps, $stamps);
        }

        return [
            'body' => json_encode($data),
            'headers' => [
                'stamps' => serialize($allStamps)
            ],
        ];
    }
}
