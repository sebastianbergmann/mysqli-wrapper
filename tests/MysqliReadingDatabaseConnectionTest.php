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
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\Medium;
use SebastianBergmann\MysqliWrapper\Testing\DatabaseTestCase;

#[CoversClass(MysqliReadingDatabaseConnection::class)]
#[CoversClass(DatabaseTestCase::class)]
#[CoversTrait(MysqliReadingDatabaseConnectionTrait::class)]
#[Medium]
final class MysqliReadingDatabaseConnectionTest extends DatabaseTestCase
{
    #[DependsExternal(MysqliWritingDatabaseConnectionTest::class, 'testCanInsertIntoTableUsingConnectionThatIsAllowedToInsertIntoTable')]
    public function testCanSelectFromTableUsingConnectionThatIsAllowedToSelectFromTable(): void
    {
        $connection = $this->connectionForReading();

        $this->assertSame(
            [['id' => 1]],
            $connection->query('SELECT id FROM test;'),
        );
    }

    /**
     * @return array{host: non-empty-string, username: non-empty-string, password: non-empty-string, database: non-empty-string}
     */
    protected function configurationForTesting(): array
    {
        return [
            'host'     => 'localhost',
            'username' => 'mysqli_wrapper_test_all_privileges',
            'password' => 'mysqli_wrapper_test_all_privileges_password',
            'database' => 'mysqli_wrapper_test',
        ];
    }

    private function connectionForReading(): MysqliReadingDatabaseConnection
    {
        return MysqliReadingDatabaseConnection::connect(
            'localhost',
            'mysqli_wrapper_test_only_select_privilege',
            'mysqli_wrapper_test_only_select_privilege_password',
            'mysqli_wrapper_test',
        );
    }
}
