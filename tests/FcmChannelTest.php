<?php

namespace Benwilkins\FCM\Tests;

use Mockery as m;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Benwilkins\FCM\FcmChannel;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Notifications\Notification;

class FcmChannelTest extends TestCase
{
    /**
     * @var Client|\Mockery\MockInterface
     */
    protected $client;

    /**
     * @var FcmChannel
     */
    protected $channel;

    /** @var TestNotification */
    protected $notification;

    /** @var Notifiable|\Mockery\MockInterface */
    protected $notifiable;

    public function setUp()
    {
        $this->events = m::mock(FcmChannel::class);
        $this->client = m::mock(Client::class);
        $this->channel = new FcmChannel($this->client, '');
        $this->notification = new TestNotification;
        $this->notifiable = m::mock(Notifiable::class);
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $response = new Response(200, [], '{}');

        $this->notifiable->shouldReceive('routeNotificationFor')
            ->andReturnTrue();

        $this->client->shouldReceive('post')
            ->once()
            ->withAnyArgs()
            ->andReturn($response);

        $this->channel->send($this->notifiable, $this->notification);
    }

    /** @test */
    public function ic_cannot_send_a_notification()
    {
        $this->notifiable->shouldReceive('routeNotificationFor')
            ->andReturnNull();

        $this->client->shouldNotReceive('post');

        $this->channel->send($this->notifiable, $this->notification);
    }
}

class TestNotification extends Notification
{
    public function toFcm($notifiable)
    {
        return new FcmMessage();
    }
}
