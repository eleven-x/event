<?php
/**
 * @author dongyu
 * @time 2016-12-28
 * @copyright Copyright (c) 2016 Simple-inc Software  inc
 */

namespace Eleven;


class Dispatcher
{

    /**
     * @var array
     */
    protected $listeners = array();


    /**
     * dispatch event
     * @param $eventName
     * @param Event|null $event
     * @return mixed|null|void
     */
    public function dispatch($eventName, Event $event = null)
    {
        if (!($event instanceof Event)) {
            $event = new Event();
        }
        return $this->toDispatch($eventName, $event);
    }

    /**
     * @param $eventName
     * @param Event $event
     * @return mixed|null|void
     */
    protected function toDispatch($eventName, Event $event)
    {

        if (!$this->hasListeners($eventName)) {
            return;
        }

        $listenerList = $this->listeners[$eventName];
        $result = null;
        foreach ($listenerList as $priority => $listeners) {
            foreach ($listeners as $key => $listener) {

                $result = $this->callListen($listener, $eventName, $event, $result);
                if ($this->isOnce($listener)) {
                    unset($this->listeners[$eventName][$priority][$key]);
                    if (empty($this->listeners[$eventName][$priority])) {
                        unset($this->listeners[$eventName][$priority]);
                        if (empty($this->listeners[$eventName])) {
                            unset($this->listeners[$eventName]);
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     *  is once
     * @param $listener
     * @return bool
     */
    protected function isOnce($listener)
    {
        return $listener[1];
    }


    /**
     * @param $listener
     * @param $eventName
     * @param Event $event
     * @param null $result
     * @return mixed
     */
    protected function callListen($listener, $eventName, Event $event, $result = null)
    {
        return call_user_func_array($listener[0], array($eventName, $event, $result));
    }


    /**
     *
     * @param string $eventName
     * @param  \Closure $listener
     */
    public function once($eventName, \Closure $listener)
    {
        $this->addListener($eventName, $listener, 0, true);
    }


    /**
     * add event listener
     * @param $eventName
     * @param \Closure $listener
     * @param int $priority
     * @param bool $once
     */
    public function addListener($eventName, \Closure $listener, $priority = 0, $once = false)
    {

        $listenerInfo = $this->composeListener($listener, $once);

        if ($this->hasListeners($eventName)) {
            $listeners = $this->listeners[$eventName];
            $listeners[$priority][] = $listenerInfo;

            // sort
            uksort($listeners, function ($k1, $k2) {
                return $k2 - $k1;
            });

            $this->listeners[$eventName] = $listeners;
        } else {
            $this->listeners[$eventName][$priority][] = $listenerInfo;
        }
    }


    /**
     * @param $listener
     * @param $once
     * @return array
     */
    protected function composeListener($listener, $once)
    {
        return array(
            $listener,
            $once,
        );
    }


    /**
     *  remove event listener
     * @param $eventName
     */
    public function removeListener($eventName)
    {
        if ($this->hasListeners($eventName)) {
            unset($this->listeners[$eventName]);
        }
    }

    /**
     * @param $eventName
     * @return bool
     */
    public function hasListeners($eventName)
    {
        return isset($this->listeners[$eventName]) && !empty($this->listeners[$eventName]);
    }


}