# laravel-fcm-notification
Laravel FCM (Firebase Cloud Messaging) Notification Channel

[![Latest Version](https://img.shields.io/github/release/benwilkins/laravel-fcm-notification.svg?style=flat-square)](https://github.com/benwilkins/laravel-fcm-notification/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Use this package to send push notifications via Laravel to Firebase Cloud Messaging. Laravel 5.3+ required.

## Install

This package can be installed through Composer.

``` bash
composer require benwilkins/laravel-fcm-notification
```

Once installed, add the service provider:

```php
// config/app.php
'providers' => [
    ...
    Benwilkins\FCM\FcmNotificationServiceProvider::class,
    ...
];
```

Add the following config to `config/services.php`. Add your Firebase Cloud Messaging API Key here.

```php

    'fcm' => [
        'key' => 'cloud-messaging-key'
    ],
```

## Example Usage

Use Artisan to create a notification:

```bash
php artisan make:notification SomeNotification
```

Return `[fcm]` in the `public function via($notifiable)` method of your notification:

```php
public function via($notifiable)
{
    return ['fcm'];
}
```

Add the method `public function toFcm($notifiable)` to your notification, and return an instance of `FcmMessage`: 

```php
public function toFcm($notifiable) 
{
    $message = new Benwilkins\FCM\FcmMessage();
    $message->content([
        'title'        => 'Foo', 
        'body'         => 'Bar', 
        'sound'        => '', // Optional 
        'icon'         => '', // Optional
        'click_action' => '' // Optional
    ])->data([
        'param1' => 'baz' // Optional
    ])->priority(Benwilkins\FCM\FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.
    
    return $message;
}
```

When sending to specific device, make sure your notifiable entity has `routeNotificationForFcm` method defined: 

```php
/**
 * Route notifications for the FCM channel.
 *
 * @return string
 */
public function routeNotificationForFcm()
{
    return $this->device_token;
}
```

When sending to a topic, you may define so within the `toFcm` method in the notification:

```php
public function toFcm($notifiable) 
{
    $message = new Benwilkins\FCM\FcmMessage();
    $message->to('the-topic', $recipientIsTopic = true)
    ->content([...])
    ->data([...]);
    
    return $message;
}
```

Or when sending with a condition:

```php
public function toFcm($notifiable) 
{
    $message = new Benwilkins\FCM\FcmMessage();
    $message->contentAvailable(true)
        ->priority('high')
        ->condition("'user_".$notifiable->id."' in topics")
        ->data([...]);
    
    return $message;
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
