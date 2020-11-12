<?php

/*
 * This file is part of the NumberNine package.
 *
 * (c) William Arin <williamarin.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NumberNine\Common\Tests\Util\ArrayUtil;

use PHPUnit\Framework\TestCase;

use function NumberNine\Common\Util\ArrayUtil\array_push_deep;

class ArrayPushDeepTest extends TestCase
{
    public function testPushNestedValueInEmptyArray(): void
    {
        $array = [];
        array_push_deep($array, 3, 'key1', 2, 'key3');

        self::assertEquals(['key1' => [2 => ['key3' => [3]]]], $array);
    }

    public function testPushNestedValueInNonEmptyArray(): void
    {
        $array = ['key1' => [2 => ['key3' => [3]]]];
        array_push_deep($array, 'some_value', 'key1', 2, 'key3');

        self::assertEquals(['key1' => [2 => ['key3' => [3, 'some_value']]]], $array);
    }
}
