<?php

namespace Benwilkins\FCM;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;

/**
 * Class FcmNotificationServiceProvider.
 */
class FcmNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register.
     */
    public function register()
    {
        $app = $this->app;
        $this->app->make(ChannelManager::class)->extend('fcm', function () use ($app) {
            return new FcmChannel(new Client(), config('services.fcm.key'));
        });
    }
}
