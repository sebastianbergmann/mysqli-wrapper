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
use PHPUnit\Framework\SkippedWithMessageException;
use PHPUnit\Framework\TestCase as PhpunitTestCase;

#[CoversTrait(Testing::class)]
#[Medium]
#[TestDox('Testing trait')]
final class TestingFailTest extends PhpunitTestCase
{
    use Testing;

    public function testSkipsTestExecutionWhenConnectingToDatabaseFails(): void
    {
        $this->expectException(SkippedWithMessageException::class);

        $this->emptyTable('test');
    }

    /**
     * @return array{host: non-empty-string, username: non-empty-string, password: non-empty-string, database: non-empty-string}
     */
    protected function configurationForTesting(): array
    {
        return [
            'host'     => '127.0.0.1',
            'username' => 'invalid',
            'password' => 'invalid',
            'database' => 'invalid',
        ];
    }
}
