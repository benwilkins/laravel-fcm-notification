<?php

namespace Benwilkins\FCM;

use GuzzleHttp\Client;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

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
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('fcm', function () {
                $version = app()->version();
                $majorVersion = explode('.', $version)[0];
                if( $majorVersion == 7){
                    return new FcmChannel(new Client(), config('services.fcm.key'));
                }
                return new FcmChannel(app(Client::class), config('services.fcm.key'));
            });
        });
    }
}
