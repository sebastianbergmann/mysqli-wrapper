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
use PHPUnit\Framework\TestCase;
use SebastianBergmann\MysqliWrapper\Testing\Testing;

#[CoversClass(MysqliWritingDatabaseConnection::class)]
#[CoversTrait(Testing::class)]
#[CoversTrait(MysqliWritingDatabaseConnectionTrait::class)]
#[Medium]
final class MysqliWritingDatabaseConnectionTest extends TestCase
{
    use Testing;

    public function testCanInsertIntoTableUsingConnectionThatIsAllowedToInsertIntoTable(): void
    {
        $this->emptyTable('test');

        $connection = $this->connectionForWriting();

        $this->assertTrue($connection->execute('INSERT INTO test () VALUES();'));
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

    private function connectionForWriting(): MysqliWritingDatabaseConnection
    {
        return MysqliWritingDatabaseConnection::connect(
            'localhost',
            'mysqli_wrapper_test_only_insert_privilege',
            'mysqli_wrapper_test_only_insert_privilege_password',
            'mysqli_wrapper_test',
        );
    }
}
