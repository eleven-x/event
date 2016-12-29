<?php

/**
 * @author dongyu
 * @time 2016-12-28
 */
class DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testhasListeners()
    {
        $dispatcher = new \Eleven\Dispatcher();
        $eventName = 'LEVEL_UP';
        $this->assertEquals(false, $dispatcher->hasListeners($eventName));
        $dispatcher->addListener($eventName, function () {
        });
        $this->assertEquals(true, $dispatcher->hasListeners($eventName));
    }


    public function testRemoveListener()
    {
        $dispatcher = new \Eleven\Dispatcher();
        $eventName = 'LEVEL_UP';
        $this->assertEquals(false, $dispatcher->hasListeners($eventName));
        $dispatcher->addListener($eventName, function () {
        });
        $this->assertEquals(true, $dispatcher->hasListeners($eventName));
        $dispatcher->removeListener($eventName);
        $this->assertEquals(false, $dispatcher->hasListeners($eventName));
    }


    public function testOnce()
    {
        $dispatcher = new \Eleven\Dispatcher();
        $eventName = 'LEVEL_UP';
        $dispatcher->once($eventName, function () {
        });


        $this->assertEquals(true, $dispatcher->hasListeners($eventName));

        $dispatcher->dispatch($eventName);

        $this->assertEquals(false, $dispatcher->hasListeners($eventName));

    }


    public function testAddListener()
    {

        $dispatcher = new \Eleven\Dispatcher();
        $eventName = 'LEVEL_UP';


        $dispatcher->addListener($eventName, function ($eventName, $event, $result) {
            if (empty($result)) {
                $result = array();
            }
            $result[] = $eventName . '#99';
            return $result;
        }, 99);

        $dispatcher->addListener($eventName, function ($eventName, $event, $result) {
            if (empty($result)) {
                $result = array();
            }
            $result[] = $eventName . '#1';
            return $result;
        }, 1);

        $dispatcher->addListener($eventName, function ($eventName, $event, $result) {
            if (empty($result)) {
                $result = array();
            }
            $result[] = $eventName . '#100';
            return $result;
        }, 100);


        $this->assertEquals(true, $dispatcher->hasListeners($eventName));
        $result = $dispatcher->dispatch($eventName);
        $this->assertEquals(true, $dispatcher->hasListeners($eventName));

        
        // test priority
        $this->assertEquals(array($eventName . '#100', $eventName . '#99', $eventName . '#1'), $result);


    }


}