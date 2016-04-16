<?php

namespace ZeusTest\Event;

function makeOutput(array $args) {
    $n      = \count($args);
    $format = \implode(':', \array_fill(0, $n, '%s'));
    $vals   = [];
    
    foreach ($args as &$arg) {
        $vals[] = \var_export($arg, true);
    }
    \array_unshift($vals, $format);
    return \call_user_func_array('\\sprintf', $vals);
}

class EmitterTest extends \PHPUnit_Framework_TestCase
{
    const EVENT1 = 'testEvent';
    const EVENT2 = 'testEvent2';
    
    private $emitter;
    private $observer;
    
    public function setUp() {
        $this->emitter = new Emitter();
        $this->observer = function ($emitter, $event, $a, $b) {
            echo 'true->' . makeOutput([$event, $a, $b]);
        };
        $this->emitter->on(self::EVENT1, $this->observer);
        $this->emitter->on(self::EVENT1, $this->observer);
        $this->emitter->on(self::EVENT2, $this->observer);
    }
    
    /**
     * @test
     * @dataProvider emitProvider
     */
    public function emit($event, $a, $b, $output) {
        $this->expectOutputString($output);
        $this->emitter->emit($event, $a, $b);
    }
    
    public function emitProvider() {
        $return = [
            [self::EVENT1, true, 1],
            [self::EVENT1, 2, 'test'],
            [self::EVENT1, 5.9, 'test'],
            [self::EVENT2, 6.8, 3],
            [self::EVENT2, 'asdfasdf', 'test'],
            ['fake', 5.9, 'test', ''],
            ['fake2', false, 'faketest', ''],
        ];
        foreach ($return as &$list) {
            if ($list[0] == self::EVENT1) {
                $list[] = 'true->' . makeOutput($list);
                $list[3] .= $list[3];
            }
            else if ($list[0] == self::EVENT2) {
                $list[] = 'true->' . makeOutput($list);
            }
        }
        return $return;
    }
    
    /**
     * @test
     */
    public function removeObserver() {
        $this->emitter->removeObserver(self::EVENT2, $this->observer);
        $this->expectOutputString('');
        $this->emitter->emit(self::EVENT2);
        $this->emitter->on(self::EVENT2, $this->observer);
    }
    
    /**
     * @test
     */
    public function removeAllObserver() {
        $this->emitter->removeAllObservers(self::EVENT2);
        $this->expectOutputString('');
        $this->emitter->emit(self::EVENT2);
        $this->emitter->on(self::EVENT2, $this->observer);
    }
}
