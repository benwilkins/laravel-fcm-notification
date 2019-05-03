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
        $this->app->make(ChannelManager::class)->extend('fcm', function () {
            return new FcmChannel(app(Client::class), config('services.fcm.key'));
        });
    }
}
