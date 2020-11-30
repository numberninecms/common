<?php

/*
 * This file is part of the NumberNine package.
 *
 * (c) William Arin <williamarin.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NumberNine\Common\Util\ConfigUtil;

use function NumberNine\Common\Util\StringUtil\human_readable_size_to_int;

/**
 * Gets the maximum size of uploadable files as defined in server's php configuration
 */
function get_file_upload_max_size(): int
{
    static $maxSize = -1;

    if ($maxSize < 0) {
        $postMaxSize = human_readable_size_to_int((string)ini_get('post_max_size'));
        $uploadMaxFileSize = human_readable_size_to_int((string)ini_get('upload_max_filesize'));

        if ($postMaxSize > 0) {
            $maxSize = $postMaxSize;
        }

        if ($uploadMaxFileSize > 0 && $uploadMaxFileSize < $maxSize) {
            $maxSize = $uploadMaxFileSize;
        }
    }

    return $maxSize;
}

/**
 * Inserts or replace an environment variable in a given file
 * @return false|int
 */
function file_put_env_variable(string $filename, string $envVariable, string $value)
{
    if (!file_exists($filename)) {
        return file_put_contents($filename, sprintf("%s=%s\n", $envVariable, $value));
    }

    $content = (string)file_get_contents($filename);

    if (preg_match('@^\s*(?!#)\b' . preg_quote($envVariable) . '\b\s*=@simU', $content)) {
        $content = preg_replace_callback(
            '@(\b' . preg_quote($envVariable) . '\b\s*=\s*?)(.*)(#.*)?(\n|$)@simU',
            function ($matches) use ($value) {
                return sprintf(
                    "%s%s%s%s",
                    $matches[1],
                    $value,
                    $matches[3] ? ' ' . $matches[3] : '',
                    $matches[4],
                );
            },
            $content
        );
        return file_put_contents($filename, $content);
    }

    return file_put_contents($filename, sprintf("\n%s=%s\n", $envVariable, $value), FILE_APPEND);
}

/**
 * Checks if an environment variable exists in a given file
 */
function file_env_variable_exists(string $filename, string $envVariable): bool
{
    if (!file_exists($filename)) {
        return false;
    }

    $content = (string)file_get_contents($filename);

    return preg_match('@^\s*(?!#)\b' . preg_quote($envVariable) . '\b\s*=@simU', $content) === 1;
}
