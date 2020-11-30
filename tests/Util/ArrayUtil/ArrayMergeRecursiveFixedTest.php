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

use function NumberNine\Common\Util\ArrayUtil\array_merge_recursive_fixed;

class ArrayMergeRecursiveFixedTest extends TestCase
{
    public function testArrayMergeRecursiveFixed(): void
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
                'array_scalar' => [0 => 3, 1 => 4, 2 => 5],
                'array_associative' => [
                    'scalar' => "B",
                    'array_scalar' => [0 => 1, 1 => 2, 2 => 3, 4 => 4, 5 => 5],
                ],
            ],
            array_merge_recursive_fixed($default, $override)
        );
    }
}
