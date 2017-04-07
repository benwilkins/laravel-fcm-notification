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
     * @var string|array
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
     * @param string|array $recipient
     * @param bool $recipientIsTopic
     * @return $this
     */
    public function to($recipient, $recipientIsTopic = false)
    {
        if ($recipientIsTopic && is_string($recipient)) {
            $this->to = '/topics/' . $recipient;
        } else {
            $this->to = $recipient;
        }

        return $this;
    }

    /**
     * @return string|array|null
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
        $payload = [
            'priority' => $this->priority,
        ];

        if (is_array($this->to)) {
            $payload['registration_ids'] = $this->to;
        } else {
            $payload['to'] = $this->to;
        }

        if (isset($this->data) && count($this->data)) {
            $payload['data'] = $this->data;
        }

        if (isset($this->notification) && count($this->notification)) {
            $payload['notification'] = $this->notification;
        }

        return \GuzzleHttp\json_encode($payload);
    }
}