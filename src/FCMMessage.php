<?php

namespace Benwilkins\FCM;

/**
 * Class FCMMessage
 * @package Benwilkins\FCM
 */
class FCMMessage
{
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';

    /**
     * @var string
     */
    private $to;
    /**
     * @var array
     */
    private $notification;
    /**
     * @var array
     */
    private $data;
    /**
     * @var string normal|high
     */
    private $priority = self::PRIORITY_NORMAL;

    /**
     * @param string $recipient
     * @param bool $recipientIsTopic
     * @return $this
     */
    public function to($recipient, $recipientIsTopic = false)
    {
        if ($recipientIsTopic) {
            $this->to = '/topics/' . $recipient;
        } else {
            $this->to = $recipient;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * The notification object to send to FCM. `title` and `body` are required.
     * @param array $params ['title' => '', 'body' => '', 'sound' => '', 'icon' => '', 'click_action' => '']
     * @return $this
     */
    public function content(array $params)
    {
        $this->notification = $params;

        return $this;
    }

    /**
     * @param array|null $data
     * @return $this
     */
    public function data($data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $priority
     * @return $this
     */
    public function priority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string
     */
    public function formatData()
    {
        return json_encode([
            'data'         => $this->data,
            'notification' => $this->notification,
            'priority'     => $this->priority,
            'to'           => $this->to
        ]);
    }
}