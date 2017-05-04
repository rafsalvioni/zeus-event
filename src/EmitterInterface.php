<?php

namespace Zeus\Event;

/**
 * Indentifies objects that emit events and could be register observers.
 * 
 * @author Rafael M. Salvioni
 */
interface EmitterInterface
{
    /**
     * Attach a observer in a event.
     * 
     * @param string $event
     * @param callable $observer
     * @return EmitterInterface
     */
    public function on(string $event, callable $observer): EmitterInterface;
    
    /**
     * Remove a observer
     * 
     * @param string $event
     * @param callable $observer
     * @return EmitterInterface
     */
    public function removeObserver(string $event, callable $observer): EmitterInterface;
    
    /**
     * Renmove all observers from object.
     *
     * If $event is null, remove all observers of all events.
     * 
     * @param string $event
     * @return EmitterInterface
     */
    public function removeAllObservers(string $event = null): EmitterInterface;
    
    /**
     * Notify the object's observers a event occurence.
     * 
     * The observer will receive these arguments: a emitter object, event string
     * and all others arguments given.
     * 
     * @param string $event
     * @return EmitterInterface
     */
    public function emit(string $event): EmitterInterface;
}
