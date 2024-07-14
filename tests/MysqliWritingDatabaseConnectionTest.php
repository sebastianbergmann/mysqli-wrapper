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

#[CoversClass(MysqliWritingDatabaseConnection::class)]
#[CoversTrait(Testing::class)]
#[CoversTrait(MysqliWritingDatabaseConnectionTrait::class)]
#[Medium]
final class MysqliWritingDatabaseConnectionTest extends TestCase
{
    public function testCanInsertIntoTableUsingConnectionThatIsAllowedToInsertIntoTable(): void
    {
        $this->emptyTable('test');

        $connection = $this->connectionForWriting();

        $this->assertTrue($connection->execute('INSERT INTO test () VALUES();'));
    }
}
