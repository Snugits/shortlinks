<?php

namespace App\Tests\Core\Domain\Service;

use App\Core\Domain\Repository\ShorLinkRepository;
use App\Core\Domain\Service\LinkGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Core\Domain\Exception\ShortLinkException;

class LinkGeneratorTest extends TestCase
{
    public function testGenerateSuccess(): void
    {
        // Given
        $linkGenerator = new LinkGenerator($this->getShorLinkRepositoryMock(1, 0));

        // When
        $result = $linkGenerator->generate('http://myawseomeurl.com');

        // Then
        self::assertNotEmpty($result);
    }

    public function testGenerateFailure(): void
    {
        $this->expectException(ShortLinkException::class);

        // Given
        $linkGenerator = new LinkGenerator($this->getShorLinkRepositoryMock(5, 3));

        // When
        $linkGenerator->generate('http://myawseomeurl.com');

    }

    /**
     * @return ShorLinkRepository|MockObject
     */
    private function getShorLinkRepositoryMock(int $countCalls, int $returnValue): MockObject
    {
        $mock = $this->createMock(ShorLinkRepository::class);
        $mock
            ->expects(self::exactly($countCalls))
            ->method('getShortLinksCountByAlias')
            ->willReturn($returnValue);

        return $mock;
    }
}