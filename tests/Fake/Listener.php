<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Event\Fake;

class Listener
{
    public function onFoo()
    {
    }

    public static function onBar()
    {
    }

    public function __invoke($object)
    {
        $object->called = true;
    }
}
