<?php

/*
 * This file is part of the NumberNine package.
 *
 * (c) William Arin <williamarin.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NumberNine\Common\Tests\Util\StringUtil;

use InvalidArgumentException;
use OverflowException;
use PHPUnit\Framework\TestCase;

use function NumberNine\Common\Util\StringUtil\human_readable_size_to_int;

class HumanReadableSizeToIntTest extends TestCase
{
    public function testOnlyPositiveNumberAllowed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        human_readable_size_to_int('-15B');
    }

    public function testOverflowThrowingException(): void
    {
        $this->expectException(OverflowException::class);
        human_readable_size_to_int('8E');
    }

    public function testByteToInt(): void
    {
        self::assertEquals(15, human_readable_size_to_int('15B'));
    }

    public function testKiloByteToInt(): void
    {
        self::assertEquals(4096, human_readable_size_to_int('4K'));
    }

    public function testMegaByteToInt(): void
    {
        self::assertEquals(2097152, human_readable_size_to_int('2M'));
    }

    public function testGigaByteToInt(): void
    {
        self::assertEquals(3221225472, human_readable_size_to_int('3G'));
    }

    public function testTeraByteToInt(): void
    {
        self::assertEquals(1099511627776, human_readable_size_to_int('1T'));
    }

    public function testPetaByteToInt(): void
    {
        self::assertEquals(5629499534213120, human_readable_size_to_int('5P'));
    }

    public function testExaByteToInt(): void
    {
        self::assertEquals(2305843009213693952, human_readable_size_to_int('2E'));
    }

    public function testZettaByteToInt(): void
    {
        self::assertEquals(1180591620717411, human_readable_size_to_int('0.000001Z'));
    }

    public function testYottaByteToInt(): void
    {
        self::assertEquals(1208925819614629120, human_readable_size_to_int('0.000001Y'));
    }
}
