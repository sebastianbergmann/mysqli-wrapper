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

use const MYSQLI_OPT_INT_AND_FLOAT_NATIVE;
use const MYSQLI_REPORT_ERROR;
use const MYSQLI_REPORT_STRICT;
use function count;
use function mysqli_report;
use function substr_count;
use mysqli;
use mysqli_sql_exception;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise
 */
abstract readonly class AbstractMysqliDatabaseConnection
{
    private mysqli $connection;

    /**
     * @param non-empty-string $host
     * @param non-empty-string $username
     * @param non-empty-string $password
     * @param non-empty-string $database
     *
     * @throws ConnectionFailedException
     */
    final public static function connect(string $host, string $username, string $password, string $database): static
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $connection = @new mysqli($host, $username, $password, $database);
        } catch (mysqli_sql_exception $e) {
            throw new ConnectionFailedException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }

        $connection->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

        return new static($connection);
    }

    final private function __construct(mysqli $mysqli)
    {
        $this->connection = $mysqli;
    }

    /**
     * @param non-empty-string        $sql
     * @param array<float|int|string> $parameters
     *
     * @throws ParameterMismatchException
     */
    final protected function ensureParameterCountMatches(string $sql, array $parameters): void
    {
        if (substr_count($sql, '?') !== count($parameters)) {
            throw new ParameterMismatchException;
        }
    }

    final protected function connection(): mysqli
    {
        return $this->connection;
    }
}
