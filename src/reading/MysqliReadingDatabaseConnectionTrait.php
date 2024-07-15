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

use const MYSQLI_ASSOC;
use function array_values;
use mysqli;
use mysqli_result;
use mysqli_sql_exception;

/**
 * @internal This trait is not covered by the backward compatibility promise
 */
trait MysqliReadingDatabaseConnectionTrait
{
    /**
     * @param non-empty-string $sql
     *
     * @throws ParameterMismatchException
     * @throws StatementDidNotReturnResultException
     * @throws StatementFailedException
     *
     * @return list<array<non-empty-string, float|int|string>>
     */
    public function query(string $sql, float|int|string ...$parameters): array
    {
        $this->ensureParameterCountMatches($sql, $parameters);

        try {
            $result = $this->connection()->execute_query($sql, array_values($parameters));

            if (!$result instanceof mysqli_result) {
                throw new StatementDidNotReturnResultException;
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            throw new StatementFailedException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }
    }

    abstract protected function ensureParameterCountMatches(string $sql, array $parameters): void;

    abstract protected function connection(): mysqli;
}
