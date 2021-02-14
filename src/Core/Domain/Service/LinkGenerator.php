<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Exception\ShortLinkException;
use App\Core\Domain\Model\ShortLink;
use App\Core\Domain\Repository\ShorLinkRepository;

final class LinkGenerator
{
    private const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';
    private const STRING_MAX_SIZE = 5;
    private const GENERATE_LIMIT = 5;

    /**
     * @var ShorLinkRepository
     */
    private $shorLinkRepository;

    public function __construct(ShorLinkRepository $shorLinkRepository)
    {
        $this->shorLinkRepository = $shorLinkRepository;
    }

    /**
     * @param string $url
     * @return ShortLink
     * @throws ShortLinkException
     */
    public function generate(string $url): ShortLink
    {
        $counter = 0;
        do {
            $alias = $this->generateRandomString();
            $isFindSimilar = $this->shorLinkRepository->getShortLinksCountByAlias($alias) > 0;
            $counter++;
        } while ($isFindSimilar > 0 && $counter < self::GENERATE_LIMIT);

        if ($isFindSimilar && $counter >= self::GENERATE_LIMIT) {
            throw new ShortLinkException("Can't generate unique alias");
        }

        return new ShortLink(null, $alias, $url);
    }

    private function generateRandomString(): string
    {
        $result = '';
        $symbolSetAmount = strlen(self::ALPHABET);

        for ($i = 0; $i < self::STRING_MAX_SIZE; $i++) {
            $randomLetter = self::ALPHABET[random_int(0, $symbolSetAmount - 1)];
            $isUppercase = random_int(0, $symbolSetAmount) % 2 === 0;

            $result .= $isUppercase ? strtoupper($randomLetter) : $randomLetter;
        }

        return $result;
    }
}