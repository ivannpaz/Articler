<?php

namespace Kazan\ArticlerTests\Cache;

use Kazan\ArticlerTests\AbstractTestCase;
use Kazan\Articler\Cache\NullCache;

class NullCacheTest extends AbstractTestCase
{

    public function testMethods()
    {
        $key     = 'key';
        $value   = 'value';
        $default = 'default value';

        $object = new NullCache();

        $this->assertFalse($object->has($key));

        $object->put($key, $value);

        $this->assertFalse($object->has($key));

        $this->assertNull($object->get($key));

        $object->forget($key);

        $this->assertFalse($object->has($key));

        $object->clear();

        $this->assertEquals($default, $object->get($key, $default));
    }

}
