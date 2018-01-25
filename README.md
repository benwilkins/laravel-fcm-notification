# laravel-fcm-notification
Laravel FCM (Firebase Cloud Messaging) Notification Channel

[![Latest Version](https://img.shields.io/github/release/benwilkins/laravel-analyst.svg?style=flat-square)](https://github.com/benwilkins/laravel-analyst/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Use this package to send push notifications via Laravel to Firebase Cloud Messaging. Laravel 5.3+ required.

## Install

This package can be installed through Composer.

``` bash
composer require benwilkins/laravel-fcm-notification:@dev-master
```

If installing on < Laravel 5.5 then add the service provider:

```php
// config/app.php
'providers' => [
    ...
    Benwilkins\FCM\FcmNotificationServiceProvider::class,
    ...
];
```

Publish the config file:

``` bash
php artisan vendor:publish --provider="Benwilkins\FCM\FcmNotificationServiceProvider"
```

The following config file will be published in `config/laravel-fcm-notification.php`. Add your Firebase API Key here.

```php
return [
    /*
     * Add the Firebase API key
     */
    'api_key' => ''
];
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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
