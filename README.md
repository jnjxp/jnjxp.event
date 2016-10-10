# jnjxp.event
Event dispatching with DI resolution.
Basically [Evenement] that can resolve listeners from DI container.

[![Latest version][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

See: [Evenement] and [Aura\DI provider]

```php
<?php

$resolver = function ($spec) use ($di) {
    return $di->get($spec);
};

$emitter = new Jnjxp\Event\Emitter($resolver);

$emitter->on('foo', Listener::class);

$emitter->emit('foo', $params);
```

[evenement]: https://github.com/igorw/evenement
[Aura\DI provider]: https://github.com/fusible/fusible.event-provider


[ico-version]: https://img.shields.io/packagist/v/jnjxp/event.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jnjxp/jnjxp.event/develop.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jnjxp/jnjxp.event.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jnjxp/jnjxp.event.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jnjxp/event
[link-travis]: https://travis-ci.org/jnjxp/jnjxp.event
[link-scrutinizer]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.event
[link-code-quality]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.event
