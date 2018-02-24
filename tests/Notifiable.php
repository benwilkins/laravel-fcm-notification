<?php

namespace Benwilkins\FCM\Tests;

class Notifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForFcm()
    {
        return 1;
    }
}
