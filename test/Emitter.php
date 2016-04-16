<?php

namespace ZeusTest\Event;

use Zeus\Event\EmitterInterface;
use Zeus\Event\EmitterTrait;

/**
 * Simple emitter for tests.
 *
 * @author Rafael M. Salvioni
 */
class Emitter implements EmitterInterface
{
    use EmitterTrait;
}
