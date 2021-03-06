<?php

namespace Zeus\Event;

/**
 * Implementation of EmitterInterface methods.
 * 
 * @author Rafael M. Salvioni
 */
trait EmitterTrait
{
    /**
     * Store registered observers
     * 
     * @var array
     */
    private $observers = [];

    /**
     * 
     * @param string $event
     * @return EmitterInterface
     */
    public function emit(string $event): EmitterInterface
    {
        if (isset($this->observers[$event])) {
            $args = \func_get_args();
            \array_unshift($args, $this);
            foreach ($this->observers[$event] as &$observer) {
                \call_user_func_array($observer, $args);
            }
        }
        return $this;
    }

    /**
     * 
     * @param string $event
     * @param callable $observer
     * @return EmitterInterface
     */
    public function on(string $event, callable $observer): EmitterInterface
    {
        if (!isset($this->observers[$event])) {
            $this->observers[$event] = [];
        }
        $this->observers[$event][] = $observer;
        return $this;
    }

    /**
     * 
     * @param string $event
     * @return EmitterInterface
     */
    public function removeAllObservers(string $event = null): EmitterInterface
    {
        if ($event && isset($this->observers[$event])) {
            unset($this->observers[$event]);
        }
        else if (!$event) {
            $this->observers = [];
        }
        return $this;
    }

    /**
     * 
     * @param string $event
     * @param callable $observer
     * @return EmitterInterface
     */
    public function removeObserver(string $event, callable $observer): EmitterInterface
    {
        if (
            isset($this->observers[$event])
            &&
            ($idx = \array_search($observer, $this->observers[$event])) !== false
        ){
            unset($this->observers[$event][$idx]);
            $this->observers[$event] = \array_values($this->observers[$event]);
        }
        return $this;
    }
}
