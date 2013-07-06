<?php

namespace Kazan\ArticlerTests\Cache;

use Kazan\ArticlerTests\AbstractTestCase;
use Kazan\Articler\Cache\VolatileCache;

class VolatileCacheTest extends AbstractTestCase
{

    public function testMethods()
    {
        $keyOne     = 'key One';
        $keyTwo     = 'key Two';
        $keyThree   = 'key Three';

        $valueOne   = 'value One';
        $valueTwo   = 'value Two';

        $default    = 'default value';

        $object = new VolatileCache();

        $this->assertFalse($object->has($keyOne));
        $this->assertFalse($object->has($keyTwo));

        $object->put($keyOne, $valueOne);
        $object->put($keyTwo, $valueTwo);

        $this->assertTrue($object->has($keyOne));
        $this->assertTrue($object->has($keyTwo));
        $this->assertFalse($object->has($keyThree));

        $object->forget($keyOne);
        
        $this->assertFalse($object->has($keyOne));
        $this->assertNull($object->get($keyOne));
        $this->assertEquals(
            $default,
            $object->get($keyOne, $default)
        );
        $this->assertNull($object->get($keyThree));

        $this->assertEquals($valueTwo, $object->get($keyTwo));

        $object->clear();

        $this->assertFalse($object->has($keyOne));
    }

}
