<?php

namespace Benwilkins\FCM;

/**
 * Class FcmMessage.
 */
class FcmMessage
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
     * @var string
     */
    private $condition;

    /**
     * @var string
     */
    private $collapseKey;

    /**
     * @var bool
     */
    private $contentAvailable;

    /**
     * @var bool
     */
    private $mutableContent;

    /**
     * @var int
     */
    private $timeToLive;

    /**
     * @var bool
     */
    private $dryRun;

    /**
     * @var string
     */
    private $packageName;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @param string|array $recipient
     * @param bool $recipientIsTopic
     * @return $this
     */
    public function to($recipient, $recipientIsTopic = false)
    {
        if ($recipientIsTopic && is_string($recipient)) {
            $this->to = '/topics/'.$recipient;
        } elseif (is_array($recipient) && count($recipient) == 1) {
            $this->to = $recipient[0];
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
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     * @return $this
     */
    public function condition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * @param string $collapseKey
     * @return $this
     */
    public function collapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * @return bool
     */
    public function isContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * @param bool $contentAvailable
     * @return $this
     */
    public function contentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMutableContent()
    {
        return $this->mutableContent;
    }

    /**
     * @param bool $mutableContent
     * @return $this
     */
    public function mutableContent($mutableContent)
    {
        $this->mutableContent = $mutableContent;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * @param int $timeToLive
     * @return $this
     */
    public function timeToLive($timeToLive)
    {
        $this->timeToLive = $timeToLive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDryRun()
    {
        return $this->dryRun;
    }

    /**
     * @param bool $dryRun
     * @return $this
     */
    public function dryRun($dryRun)
    {
        $this->dryRun = $dryRun;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * @param string $packageName
     * @return $this
     */
    public function packageName($packageName)
    {
        $this->packageName = $packageName;

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
        } elseif (! empty($this->to)) {
            $payload['to'] = $this->to;
        }

        if (isset($this->data) && count($this->data)) {
            $payload['data'] = $this->data;
        }

        if (isset($this->notification) && count($this->notification)) {
            $payload['notification'] = $this->notification;
        }

        if (isset($this->condition) && ! empty($this->condition)) {
            $payload['condition'] = $this->condition;
        }

        if (isset($this->collapseKey) && ! empty($this->collapseKey)) {
            $payload['collapse_key'] = $this->collapseKey;
        }

        if (isset($this->contentAvailable)) {
            $payload['content_available'] = $this->contentAvailable;
        }

        if (isset($this->mutableContent)) {
            $payload['mutable_content'] = $this->mutableContent;
        }

        if (isset($this->timeToLive)) {
            $payload['time_to_live'] = $this->timeToLive;
        }

        if (isset($this->dryRun)) {
            $payload['dry_run'] = $this->dryRun;
        }

        if (isset($this->packageName) && ! empty($this->packageName)) {
            $payload['restricted_package_name'] = $this->packageName;
        }

        return \GuzzleHttp\json_encode($payload);
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders($headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
