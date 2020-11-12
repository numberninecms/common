<?php

/*
 * This file is part of the NumberNine package.
 *
 * (c) William Arin <williamarin.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NumberNine\Common\Util\StringUtil;

use InvalidArgumentException;

/**
 * Converts a human readable size to number in byte.
 *
 * Example: human_readable_size_to_int('2K') = 2048
 */
function human_readable_size_to_int(string $size): int
{
    if (strpos(trim($size), '-') === 0) {
        throw new InvalidArgumentException('Number cannot be negative.');
    }

    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
    $size = preg_replace('/[^0-9.]/', '', $size);

    if ($unit) {
        $result = (int)round((float)$size * (1024 ** (int)stripos('bkmgtpezy', $unit[0])));

        if ($size > 0 && $result <= 0) {
            throw new \OverflowException('Resulting number is too big and cannot be handled by PHP.');
        }

        return $result;
    }

    return (int)round((float)$size);
}
