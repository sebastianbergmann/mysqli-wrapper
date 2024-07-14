<?php declare(strict_types=1);
/*
 * This file is part of sebastian/mysqli-wrapper.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\MysqliWrapper\Testing;

use function array_keys;
use function count;
use function implode;
use function iterator_to_array;
use function sprintf;
use PHPUnit\Framework\Assert;
use SebastianBergmann\CsvParser\Parser as CsvParser;
use SebastianBergmann\CsvParser\Schema as CsvSchema;
use SebastianBergmann\MysqliWrapper\MysqliDatabaseConnection;
use Throwable;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise
 */
trait Testing
{
    /**
     * @param non-empty-string $path
     * @param non-empty-string $tableName
     */
    final protected function assertTableEqualsCsvFile(string $path, string $tableName, CsvSchema $schema): void
    {
        $this->assertTableEqualsArray(
            /** @phpstan-ignore argument.type */
            iterator_to_array($this->csvParser()->parse($path, $schema)),
            $tableName,
        );
    }

    /**
     * @param list<array<string, float|int|string>> $expected
     * @param non-empty-string                      $tableName
     */
    final protected function assertTableEqualsArray(array $expected, string $tableName): void
    {
        $this->assertNumberOfRowsInTable(count($expected), $tableName);

        $this->assertQuery(
            $expected,
            sprintf(
                'SELECT %s FROM %s;',
                implode(', ', array_keys($expected[0])),
                $tableName,
            ),
        );
    }

    /**
     * @param non-negative-int $expected
     * @param non-empty-string $tableName
     */
    final protected function assertNumberOfRowsInTable(int $expected, string $tableName): void
    {
        $result = $this->connectionForTesting()->query(
            sprintf(
                'SELECT COUNT(*) AS count FROM %s;',
                $tableName,
            ),
        );

        Assert::assertSame($expected, $result[0]['count']);
    }

    /**
     * @param list<array<string, float|int|string>> $expected
     * @param non-empty-string                      $query
     */
    final protected function assertQuery(array $expected, string $query, float|int|string ...$parameters): void
    {
        Assert::assertSame($expected, $this->connectionForTesting()->query($query, ...$parameters));
    }

    /**
     * @param non-empty-string $table
     */
    final protected function emptyTable(string $table): void
    {
        $this->connectionForTesting()->execute('TRUNCATE TABLE ' . $table . ';');
    }

    /**
     * @return array{host: non-empty-string, username: non-empty-string, password: non-empty-string, database: non-empty-string}
     */
    abstract protected function configurationForTesting(): array;

    private function connectionForTesting(): MysqliDatabaseConnection
    {
        $configuration = $this->configurationForTesting();

        try {
            return MysqliDatabaseConnection::connect(
                $configuration['host'],
                $configuration['username'],
                $configuration['password'],
                $configuration['database'],
            );
        } catch (Throwable) {
            Assert::markTestSkipped('Could not connect to test database');
        }
    }

    private function csvParser(): CsvParser
    {
        $parser = new CsvParser;

        $parser->ignoreFirstLine();
        $parser->setSeparator(';');

        return $parser;
    }
}
