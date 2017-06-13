<?php

namespace Benwilkins\FCM;

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
            return $app->make(FcmChannel::class);
        });
    }
}