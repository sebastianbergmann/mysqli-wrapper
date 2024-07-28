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

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\CsvParser\FieldDefinition as CsvFieldDefinition;
use SebastianBergmann\CsvParser\Schema as CsvSchema;
use SebastianBergmann\CsvParser\Type as CsvType;

#[CoversTrait(Testing::class)]
#[Medium]
#[TestDox('Testing trait')]
final class TestingTest extends TestCase
{
    protected function setUp(): void
    {
        $this->emptyTable('test');

        $this->nativeConnection()->query('INSERT INTO test (a, b, c) VALUES("test", 1234, 12.34);');
    }

    #[TestDox('assertQuery() succeeds when query result matches array')]
    public function testCanCompareQueryResultToArraySuccess(): void
    {
        $this->assertQuery(
            [
                [
                    'a' => 'test',
                    'b' => 1234,
                    'c' => 12.34,
                ],
            ],
            'SELECT * FROM test;',
        );
    }

    #[TestDox('assertQuery() fails when query result does not match array')]
    public function testCanCompareQueryResultToArrayFailure(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertQuery(
            [
            ],
            'SELECT * FROM test;',
        );
    }

    #[TestDox('assertTableEqualsArray() succeeds when table matches array')]
    public function testCanCompareTableToArraySuccess(): void
    {
        $this->assertTableEqualsArray(
            [
                [
                    'a' => 'test',
                    'b' => 1234,
                    'c' => 12.34,
                ],
            ],
            'test',
        );
    }

    #[TestDox('assertTableEqualsArray() fails when table does not match array')]
    public function testCanCompareTableToArrayFailure(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertTableEqualsArray(
            [
            ],
            'test',
        );
    }

    #[TestDox('assertTableEqualsCsvFile() succeeds when table matches CSV file')]
    public function testCanCompareTableToCsvFileSuccess(): void
    {
        $this->assertTableEqualsCsvFile(
            __DIR__ . '/../../expectation/success.csv',
            'test',
            CsvSchema::from(
                CsvFieldDefinition::from(1, 'a', CsvType::string()),
                CsvFieldDefinition::from(2, 'b', CsvType::integer()),
                CsvFieldDefinition::from(3, 'c', CsvType::float()),
            ),
        );
    }

    #[TestDox('assertTableEqualsCsvFile() fails when table does not match CSV file')]
    public function testCanCompareTableToCsvFileFailure(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertTableEqualsCsvFile(
            __DIR__ . '/../../expectation/failure.csv',
            'test',
            CsvSchema::from(
                CsvFieldDefinition::from(1, 'a', CsvType::string()),
                CsvFieldDefinition::from(2, 'b', CsvType::integer()),
                CsvFieldDefinition::from(3, 'c', CsvType::float()),
            ),
        );
    }
}
