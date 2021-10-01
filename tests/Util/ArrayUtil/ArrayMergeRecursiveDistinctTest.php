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

use function NumberNine\Common\Util\ArrayUtil\array_merge_recursive_distinct;

class ArrayMergeRecursiveDistinctTest extends TestCase
{
    public function testRegularScalarMerge(): void
    {
        $default = [
            'scalar1' => 1,
            'scalar2' => 'Apple',
            'array_scalar' => [3, 4, 5],
            'array_associative' => [
                'scalar' => 1,
                'array_scalar' => [1, 2, 3],
            ],
        ];

        $override = [
            'scalar1' => 'A',
            'array_scalar' => [3, 4, 5],
            'array_associative' => [
                'scalar' => 'B',
                'array_scalar' => [3, 4, 5],
            ],
        ];

        self::assertEquals(
            [
                'scalar1' => "A",
                'scalar2' => "Apple",
                'array_scalar' => [3, 4, 5, 3, 4, 5],
                'array_associative' => [
                    'scalar' => "B",
                    'array_scalar' => [1, 2, 3, 3, 4, 5],
                ],
            ],
            array_merge_recursive_distinct($default, $override)
        );
    }

    public function testNumericKeysArrayMerge(): void
    {
        $default = [
            'array_scalar' => [0 => ['a' => 'b'], 1 => ['b' => 'c'], 2 => ['c' => 'd']],
        ];

        $override = [
            'array_scalar' => [0 => ['a' => 'b'], 2 => ['c' => 'd'], 3 => ['d' => 'e']],
        ];

        self::assertEquals(
            [
                'array_scalar' => [
                    ['a' => 'b'],
                    ['b' => 'c'],
                    ['c' => 'd'],
                    ['a' => 'b'],
                    ['c' => 'd'],
                    ['d' => 'e'],
                ],
            ],
            array_merge_recursive_distinct($default, $override)
        );
    }
}
