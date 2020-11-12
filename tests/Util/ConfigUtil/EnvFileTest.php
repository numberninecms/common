<?php

/*
 * This file is part of the NumberNine package.
 *
 * (c) William Arin <williamarin.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NumberNine\Common\Tests\Util\ConfigUtil;

use PHPUnit\Framework\TestCase;

use function NumberNine\Common\Util\ConfigUtil\file_env_variable_exists;
use function NumberNine\Common\Util\ConfigUtil\file_put_env_variable;

class EnvFileTest extends TestCase
{
    private string $filename;

    public function setUp(): void
    {
        $this->filename = sys_get_temp_dir() . '/.env.test';
    }

    public function testEnvFileVariableDoesntExist(): void
    {
        file_put_contents($this->filename, '');
        self::assertFalse(file_env_variable_exists($this->filename, 'MY_ENV_VARIABLE'));
    }

    public function testEnvFileVariableDoesntExistIfCommented(): void
    {
        file_put_contents($this->filename, '# MY_ENV_VARIABLE=some_value');
        self::assertFalse(file_env_variable_exists($this->filename, 'MY_ENV_VARIABLE'));
    }

    public function testEnvFileVariableExists(): void
    {
        file_put_contents($this->filename, 'MY_ENV_VARIABLE=some_value');
        self::assertTrue(file_env_variable_exists($this->filename, 'MY_ENV_VARIABLE'));
    }

    public function testEnvFileVariableIsWritten(): void
    {
        file_put_contents($this->filename, '');
        self::assertNotEquals(false, file_put_env_variable($this->filename, 'MY_ENV_VARIABLE', 'some_value'));
        self::assertTrue(file_env_variable_exists($this->filename, 'MY_ENV_VARIABLE'));
        self::assertStringContainsString('MY_ENV_VARIABLE=some_value', (string)file_get_contents($this->filename));
    }

    public function testEnvFileVariableIsWrittenIfCommented(): void
    {
        file_put_contents($this->filename, '# MY_ENV_VARIABLE=some_value');
        self::assertNotEquals(false, file_put_env_variable($this->filename, 'MY_ENV_VARIABLE', 'some_new_value'));
        self::assertTrue(file_env_variable_exists($this->filename, 'MY_ENV_VARIABLE'));
        self::assertStringContainsString('# MY_ENV_VARIABLE=some_value', (string)file_get_contents($this->filename));
        self::assertStringContainsString('MY_ENV_VARIABLE=some_new_value', (string)file_get_contents($this->filename));
    }

    public function testEnvFileVariableIsOverwritten(): void
    {
        file_put_contents($this->filename, 'MY_ENV_VARIABLE=some_value');
        self::assertNotEquals(false, file_put_env_variable($this->filename, 'MY_ENV_VARIABLE', 'some_new_value'));
        self::assertTrue(file_env_variable_exists($this->filename, 'MY_ENV_VARIABLE'));
        self::assertStringNotContainsString('MY_ENV_VARIABLE=some_value', (string)file_get_contents($this->filename));
        self::assertStringContainsString('MY_ENV_VARIABLE=some_new_value', (string)file_get_contents($this->filename));
    }
}
