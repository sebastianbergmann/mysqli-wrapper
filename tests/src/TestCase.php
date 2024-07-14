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

use PHPUnit\Framework\TestCase as PhpunitTestCase;
use SebastianBergmann\MysqliWrapper\MysqliReadingDatabaseConnection;
use SebastianBergmann\MysqliWrapper\MysqliWritingDatabaseConnection;

abstract class TestCase extends PhpunitTestCase
{
    use Testing;

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

    protected function connectionForReading(): MysqliReadingDatabaseConnection
    {
        return MysqliReadingDatabaseConnection::connect(
            'localhost',
            'mysqli_wrapper_test_only_select_privilege',
            'mysqli_wrapper_test_only_select_privilege_password',
            'mysqli_wrapper_test',
        );
    }

    protected function connectionForWriting(): MysqliWritingDatabaseConnection
    {
        return MysqliWritingDatabaseConnection::connect(
            'localhost',
            'mysqli_wrapper_test_only_insert_privilege',
            'mysqli_wrapper_test_only_insert_privilege_password',
            'mysqli_wrapper_test',
        );
    }
}
