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

use function NumberNine\Common\Util\ArrayUtil\array_implode_associative;

class ArrayImplodeAssociativeTest extends TestCase
{
    public function testImplodeDefaults(): void
    {
        self::assertEquals(
            'key1=value1;key2=value2',
            array_implode_associative(['key1' => 'value1', 'key2' => 'value2'])
        );
    }

    public function testImplodeInlineCssStyle(): void
    {
        self::assertEquals(
            'width:10px;background-color:#ff0000',
            array_implode_associative(['width' => '10px', 'background-color' => '#ff0000'], ';', ':')
        );
    }

    public function testImplodeShortcodeStyle(): void
    {
        self::assertEquals(
            'param1="value1" param2="value2"',
            array_implode_associative(['param1' => 'value1', 'param2' => 'value2'], ' ', '=', '', '"')
        );
    }
}
