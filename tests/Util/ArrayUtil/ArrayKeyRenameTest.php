<?php

/*
 * This file is part of the NumberNine package.
 *
 * (c) William Arin <williamarin.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace NumberNine\Common\Tests\Util\ArrayUtil;

use PHPUnit\Framework\TestCase;

use function NumberNine\Common\Util\ArrayUtil\array_key_rename;

class ArrayKeyRenameTest extends TestCase
{
    public function testKeyRenameWithOriginalValue(): void
    {
        $array = ['key' => 'value'];
        array_key_rename($array, 'key', 'new_key');

        self::assertEquals(['new_key' => 'value'], $array);
    }

    public function testKeyRenameWithNewValue(): void
    {
        $array = ['key' => 'value'];
        array_key_rename($array, 'key', 'new_key', 'new_value');

        self::assertEquals(['new_key' => 'new_value'], $array);
    }

    public function testNonexistentKeyRename(): void
    {
        $array = ['key' => 'value'];
        array_key_rename($array, 'nonexistent_key', 'new_key');

        self::assertEquals(['key' => 'value'], $array);
    }
}
