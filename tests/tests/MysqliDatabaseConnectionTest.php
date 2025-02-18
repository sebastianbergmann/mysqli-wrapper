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
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\Attributes\TestDox;
use SebastianBergmann\MysqliWrapper\Testing\TestCase;

#[CoversClass(MysqliDatabaseConnection::class)]
#[CoversClass(AbstractMysqliDatabaseConnection::class)]
#[Medium]
#[TestDox('MysqliDatabaseConnection class')]
final class MysqliDatabaseConnectionTest extends TestCase
{
    public function testRaisesAnExceptionWhenConnectingToDatabaseFails(): void
    {
        $this->expectException(ConnectionFailedException::class);

        MysqliDatabaseConnection::connect(
            '127.0.0.1',
            'mysqli_wrapper_test_all',
            'mysqli_wrapper_test_all_password',
            'invalid',
        );
    }
}
