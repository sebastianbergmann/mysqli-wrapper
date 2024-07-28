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

use function array_values;
use mysqli;
use mysqli_sql_exception;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise
 *
 * @internal This trait is not covered by the backward compatibility promise
 */
trait MysqliWritingDatabaseConnectionTrait
{
    /**
     * @param non-empty-string $sql
     *
     * @throws ParameterMismatchException
     * @throws StatementFailedException
     * @throws StatementReturnedResultException
     */
    public function execute(string $sql, float|int|string ...$parameters): true
    {
        $this->ensureParameterCountMatches($sql, $parameters);

        try {
            $result = $this->connection()->execute_query($sql, array_values($parameters));
        } catch (mysqli_sql_exception $e) {
            throw new StatementFailedException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }

        if ($result !== true) {
            throw new StatementReturnedResultException;
        }

        return true;
    }

    abstract protected function ensureParameterCountMatches(string $sql, array $parameters): void;

    abstract protected function connection(): mysqli;
}
