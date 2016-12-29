<?php
/**
 * @author dongyu
 * @time 2016-12-28
 * @copyright Copyright (c) 2016 Simple-inc Software  inc
 */

namespace Eleven;


class Event
{


    /**
     * @var int The time that the event was created
     */
    protected $timeStamp;

    /**
     *
     * @var array
     */
    protected $payload = [];


    /**
     * Event constructor.
     * @param array $payload
     * @param int $timeStamp
     */
    public function __construct(array $payload = [], $timeStamp = 0)
    {
        $this->timeStamp = $timeStamp > 0 ? $timeStamp : time();
        $this->payload = $payload;
    }

    /**
     * @return int
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * @param int $timeStamp
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }


}