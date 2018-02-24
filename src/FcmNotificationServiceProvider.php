<?php

namespace Benwilkins\FCM;

use GuzzleHttp\Client;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

/**
 * Class FcmNotificationServiceProvider
 * @package Benwilkins\FCM
 */
class FcmNotificationServiceProvider extends ServiceProvider
{

    /**
     * Register
     */
    public function register()
    {
        $app = $this->app;
        $this->app->make(ChannelManager::class)->extend('fcm', function() use ($app) {
            return new FcmChannel(new Client(), config('services.fcm.key'));
        });
    }
}