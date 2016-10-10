<?php
/**
 * Event Emitter (HEAVILY based on evenement/evenement)
 *
 * PHP version 5
 *
 * Copyright (C) 2016 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  Emitter
 * @package   Jnjxp\Event
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.event
 */

namespace Jnjxp\Event;

/**
 * Emitter
 *
 * @category Emitter
 * @package  Jnjxp\Event
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.event
 */
class Emitter
{
    /**
     * Listener specs
     *
     * @var array
     *
     * @access protected
     */
    protected $listeners = [];

    /**
     * Resolver
     *
     * @var callable
     *
     * @access protected
     */
    protected $resolver;

    /**
     * __construct
     *
     * @param callable $resolver spec resolver
     *
     * @access public
     */
    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    /**
     * Add Listener to event
     *
     * @param string $event    name of event
     * @param mixed  $listener listener spec
     *
     * @return null
     *
     * @access public
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function on($event, $listener)
    {
        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }
        $this->listeners[$event][] = $listener;
    }

    /**
     * Add one time listener
     *
     * @param string $event    name of event
     * @param mixed  $listener listener spec
     *
     * @return null
     *
     * @access public
     */
    public function once($event, $listener)
    {
        $onceListener = function () use (&$onceListener, $event, $listener) {
            $this->removeListener($event, $onceListener);
            $listener = $this->resolve($listener);
            call_user_func_array($listener, func_get_args());
        };
        $this->on($event, $onceListener);
    }

    /**
     * Remove listener
     *
     * @param string $event    name of event
     * @param mixed  $listener listener spec
     *
     * @return null
     *
     * @access public
     */
    public function removeListener($event, $listener)
    {
        if (isset($this->listeners[$event])) {
            $index = array_search($listener, $this->listeners[$event], true);
            if (false !== $index) {
                unset($this->listeners[$event][$index]);
            }
        }
    }

    /**
     * Remove all listeners
     *
     * @param null|string $event name of event
     *
     * @return null
     *
     * @access public
     */
    public function removeAllListeners($event = null)
    {
        if ($event !== null) {
            unset($this->listeners[$event]);
        } else {
            $this->listeners = [];
        }
    }

    /**
     * Get listeners for event
     *
     * @param string $event event anme
     *
     * @return array
     *
     * @access public
     */
    public function listeners($event)
    {
        return isset($this->listeners[$event]) ? $this->listeners[$event] : [];
    }

    /**
     * Emit event signal
     *
     * @param string $event     name of event
     * @param array  $arguments event arguments
     *
     * @return null
     *
     * @access public
     */
    public function emit($event, array $arguments = [])
    {
        foreach ($this->listeners($event) as $listener) {
            $listener = $this->resolve($listener);
            call_user_func_array($listener, $arguments);
        }
    }

    /**
     * Resolve
     *
     * @param mixed $spec listener spec
     *
     * @return mixed
     *
     * @access protected
     */
    protected function resolve($spec)
    {
        if (! $this->resolver) {
            return $spec;
        }

        return call_user_func($this->resolver, $spec);
    }
}
