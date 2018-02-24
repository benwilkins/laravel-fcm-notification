<?php

namespace Benwilkins\FCM\Tests;

use Benwilkins\FCM\FcmMessage;

class FcmMessageTest extends TestCase
{
    /** @var FcmMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();
        $this->message = new FcmMessage();
    }

    /** @test */
    public function it_has_default_priority()
    {
        $priority = json_decode($this->message->formatData(), true)['priority'];
        $this->assertEquals($priority, FcmMessage::PRIORITY_NORMAL);
    }

}