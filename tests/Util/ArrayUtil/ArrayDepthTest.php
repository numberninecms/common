<?php

declare(strict_types=1);

namespace NumberNine\Common\Tests\Util\ArrayUtil;

use PHPUnit\Framework\TestCase;

use function NumberNine\Common\Util\ArrayUtil\array_depth;

final class ArrayDepthTest extends TestCase
{
    public function testFlatArray(): void
    {
        $array = range(1, 10);
        self::assertEquals(1, array_depth($array));
    }

    public function testMultiDimensionalArrayWithoutChildrenKey(): void
    {
        $array = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        self::assertEquals(1, array_depth($array));
    }

    public function testMultiDimensionalArrayWithChildrenKeyDepth2(): void
    {
        $array = [
            ['id' => 1],
            ['id' => 2, 'children' => [
                ['id' => 4],
            ]],
            ['id' => 3],
        ];

        self::assertEquals(2, array_depth($array));
    }

    public function testMultiDimensionalArrayWithChildrenKeyDepth3(): void
    {
        $array = [
            ['id' => 1],
            ['id' => 2, 'children' => [
                ['id' => 4, 'children' => [
                    ['id' => 5],
                ]]],
            ],
            ['id' => 3],
        ];

        self::assertEquals(3, array_depth($array));
    }

    public function testMultiDimensionalArrayWithCustomChildrenKey(): void
    {
        $array = [
            ['id' => 1],
            ['id' => 2, 'nodes' => [
                ['id' => 4, 'nodes' => [
                    ['id' => 5],
                ]]],
            ],
            ['id' => 3],
        ];

        self::assertEquals(3, array_depth($array, 'nodes'));
    }
}
