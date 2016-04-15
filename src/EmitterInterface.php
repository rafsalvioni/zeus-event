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
     * Register a observer.
     * 
     * @param string $event
     * @param callable $observer
     * @return static
     */
    public function registerObserver($event, callable $observer);
    
    /**
     * Remove a observer
     * 
     * @param string $event
     * @param callable $observer
     * @return static
     */
    public function removeObserver($event, callable $observer);
    
    /**
     * Renmove all observers from object.
     *
     * If $event is null, remove all observers of all events.
     * 
     * @param string $event
     * @return static
     */
    public function removeAllObservers($event = null);
    
    /**
     * Notify the object's observers a event occurence.
     * 
     * The observer will receive these arguments: a emitter object, event string
     * and all others arguments given.
     * 
     * @param string $event
     * @return static
     */
    public function emit($event);
}
