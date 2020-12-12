<?php

namespace Benwilkins\FCM;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

/**
 * Class FcmChannel.
 */
class FcmChannel
{
    /**
     * @const The API URL for Firebase
     */
    const API_URI = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param  Client  $client
     */
    public function __construct(Client $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var FcmMessage $message */
        $message = $notification->toFcm($notifiable);

        if (is_null($message->getTo()) && is_null($message->getCondition())) {
            if (! $to = $notifiable->routeNotificationFor('fcm', $notification)) {
                return;
            }

            $message->to($to);
        }

        $toChunks = is_array($message->getTo()) ?
                    array_chunk($message->getTo(), 1000) :
                    [[$message->getTo()]];

        $response = [
            'toChunks' => $toChunks,
            'outputs' => []
        ];

        foreach ($toChunks as $toChunk) {
            $message->to($toChunk);
            $response['outputs'][] = $this->makeCall($message->formatData());
        }

        return $response;
    }

    /**
     * Prepare client and make call
     *
     * @param string $body
     * @return string
     */
    public function makeCall($body)
    {
        $call = $this->client->post(self::API_URI, [
            'headers' => [
                'Authorization' => 'key='.$this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'body' => $body,
        ]);

        return \GuzzleHttp\json_decode($call->getBody(), true);
    }
}
