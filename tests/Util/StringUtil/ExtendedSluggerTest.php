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

use NumberNine\Common\Util\StringUtil\ExtendedSlugger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ExtendedSluggerTest extends TestCase
{
    private ExtendedSlugger $slugger;
    private string $directory;

    public function setUp(): void
    {
        $this->slugger = new ExtendedSlugger(new AsciiSlugger(), 'en');
        $this->directory = sys_get_temp_dir() . '/slugger_test/';

        $filesystem = new Filesystem();
        $filesystem->remove($this->directory);

        if (
            !mkdir($concurrentDirectory = $this->directory, 0777, true)
            && !is_dir($concurrentDirectory)
        ) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
    }

    public function testUniqueSlugWithNoDuplicate(): void
    {
        self::assertEquals('my-file.txt', $this->slugger->getUniqueFilenameSlug($this->directory, 'my-file.txt'));
    }

    public function testUniqueSlugWithOneDuplicate(): void
    {
        file_put_contents($this->directory . '/my-file.txt', '');
        self::assertEquals('my-file-01.txt', $this->slugger->getUniqueFilenameSlug($this->directory, 'my-file.txt'));
    }

    public function testUniqueSlugWithTwoDuplicates(): void
    {
        file_put_contents($this->directory . '/my-file.txt', '');
        file_put_contents($this->directory . '/my-file-01.txt', '');
        self::assertEquals('my-file-02.txt', $this->slugger->getUniqueFilenameSlug($this->directory, 'my-file.txt'));
    }

    public function testUniqueSlugWithNonSequentialDuplicates(): void
    {
        file_put_contents($this->directory . '/my-file.txt', '');
        file_put_contents($this->directory . '/my-file-08.txt', '');
        self::assertEquals('my-file-09.txt', $this->slugger->getUniqueFilenameSlug($this->directory, 'my-file.txt'));
    }
}
