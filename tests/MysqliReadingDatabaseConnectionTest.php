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
use SebastianBergmann\MysqliWrapper\Testing\TestCase;
use SebastianBergmann\MysqliWrapper\Testing\Testing;

#[CoversClass(MysqliReadingDatabaseConnection::class)]
#[CoversTrait(Testing::class)]
#[CoversTrait(MysqliReadingDatabaseConnectionTrait::class)]
#[Medium]
final class MysqliReadingDatabaseConnectionTest extends TestCase
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
}
