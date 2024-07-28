<?php declare(strict_types=1);
/*
 * This file is part of sebastian/mysqli-wrapper.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\MysqliWrapper;

use RuntimeException;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise
 */
final class ConnectionFailedException extends RuntimeException implements Exception
{
}
