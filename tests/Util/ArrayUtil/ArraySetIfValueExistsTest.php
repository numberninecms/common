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

use function NumberNine\Common\Util\ArrayUtil\array_set_if_value_exists;

class ArraySetIfValueExistsTest extends TestCase
{
    public function testNullValueNonStrict(): void
    {
        $array = [];
        array_set_if_value_exists($array, 'key', 0);

        self::assertArrayNotHasKey('key', $array);
    }

    public function testNullValueStrict(): void
    {
        $array = [];
        array_set_if_value_exists($array, 'key', 0, null, true);

        self::assertEquals(['key' => 0], $array);
    }

    public function testNullValueFormatting(): void
    {
        $array = [];
        array_set_if_value_exists($array, 'key', 10, sprintf('%dpx', 10), true);

        self::assertEquals(['key' => '10px'], $array);
    }
}
