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

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\Medium;
use SebastianBergmann\MysqliWrapper\Testing\TestCase;
use SebastianBergmann\MysqliWrapper\Testing\Testing;

#[CoversClass(MysqliReadingDatabaseConnection::class)]
#[CoversClass(ParameterMismatchException::class)]
#[CoversClass(StatementFailedException::class)]
#[CoversClass(StatementDidNotReturnResultException::class)]
#[CoversTrait(Testing::class)]
#[CoversTrait(MysqliReadingDatabaseConnectionTrait::class)]
#[Medium]
final class MysqliReadingDatabaseConnectionTest extends TestCase
{
    protected function setUp(): void
    {
        $this->emptyTable('test');

        $this->nativeConnection()->query('INSERT INTO test (a, b, c) VALUES("test", 1234, 12.34);');
    }

    public function testCanExecuteReadStatement(): void
    {
        $connection = $this->connectionForReading();

        $result = $connection->query(
            'SELECT * FROM test WHERE a = ?;',
            'test',
        );

        $this->assertSame(
            [
                [
                    'a' => 'test',
                    'b' => 1234,
                    'c' => 12.34,
                ],
            ],
            $result,
        );
    }

    public function testCannotExecuteReadStatementWhenParameterCountDoesNotMatch(): void
    {
        $connection = $this->connectionForReading();

        $this->expectException(ParameterMismatchException::class);

        $connection->query(
            'SELECT * FROM test WHERE a = ?;',
        );
    }

    public function testRaisesAnExceptionWhenStatementFails(): void
    {
        $connection = $this->connectionForReading();

        $this->expectException(StatementFailedException::class);

        $connection->query('SELECT * FROM');
    }

    public function testRaisesAnExceptionWhenStatementDoesNotReturnResult(): void
    {
        $this->expectException(StatementDidNotReturnResultException::class);

        $this->connectionForReadingAndWriting()->query('INSERT INTO test (a, b, c) VALUES("test", 1234, 12.34);');
    }
}