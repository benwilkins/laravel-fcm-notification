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
    private $apikey;

    /**
     * @param Client $client
     */
    public function __construct(Client $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param mixed $notifiable
     * @param Notification $notification
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
        
        if (is_array($message->getTo())) {
            $chunks = array_chunk($message->getTo(), 1000);

            foreach ($chunks as $chunk) {
                $message->to($chunk);

                $response = $this->client->post(self::API_URI, [
                    'headers' => [
                        'Authorization' => 'key='.$this->apiKey,
                        'Content-Type'  => 'application/json',
                    ],
                    'body' => $message->formatData(),
                ]);
            }
        } else {
            $response = $this->client->post(self::API_URI, [
                'headers' => [
                    'Authorization' => 'key='.$this->apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'body' => $message->formatData(),
            ]);
        }

        return \GuzzleHttp\json_decode($response->getBody(), true);
    }
}
