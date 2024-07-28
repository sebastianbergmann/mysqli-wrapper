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
use mysqli_result;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\Attributes\TestDox;
use SebastianBergmann\MysqliWrapper\Testing\TestCase;
use SebastianBergmann\MysqliWrapper\Testing\Testing;

#[CoversClass(MysqliWritingDatabaseConnection::class)]
#[CoversClass(ParameterMismatchException::class)]
#[CoversClass(StatementFailedException::class)]
#[CoversClass(StatementReturnedResultException::class)]
#[CoversTrait(Testing::class)]
#[CoversTrait(MysqliWritingDatabaseConnectionTrait::class)]
#[Medium]
#[TestDox('MysqliWritingDatabaseConnection class')]
final class MysqliWritingDatabaseConnectionTest extends TestCase
{
    protected function setUp(): void
    {
        $this->emptyTable('test');
    }

    public function testCanExecuteWriteStatement(): void
    {
        $connection = $this->connectionForWriting();

        $result = $connection->execute(
            'INSERT INTO test (a, b, c) VALUES(?, ?, ?);',
            'test',
            1234,
            12.34,
        );

        $this->assertTrue($result);

        $result = $this->nativeConnection()->query('SELECT * FROM test;');

        $this->assertInstanceOf(mysqli_result::class, $result);

        $this->assertSame(
            [
                [
                    'a' => 'test',
                    'b' => 1234,
                    'c' => 12.34,
                ],
            ],
            $result->fetch_all(MYSQLI_ASSOC),
        );
    }

    public function testRaisesAnExceptionWhenParameterCountDoesNotMatch(): void
    {
        $connection = $this->connectionForWriting();

        $this->expectException(ParameterMismatchException::class);

        $connection->execute(
            'INSERT INTO test (a, b, c) VALUES(?, ?, ?);',
            'test',
            1234,
        );
    }

    public function testRaisesAnExceptionWhenStatementFailsToExecute(): void
    {
        $connection = $this->connectionForWriting();

        $this->expectException(StatementFailedException::class);

        $connection->execute('INSERT INTO ...;');
    }

    public function testRaisesAnExceptionWhenStatementReturnsResult(): void
    {
        $this->expectException(StatementReturnedResultException::class);
        $this->expectExceptionMessage('Statement unexpectedly returned a result');

        $this->connectionForReadingAndWriting()->execute('SELECT * FROM test;');
    }
}
