<?php

namespace App\Core\Application\Service;

use App\Core\Domain\Repository\ShorLinkRepository;
use App\Core\Domain\Service\LinkGenerator;

class ShortLinkService
{
    public function __construct(private LinkGenerator $linkGenerator, private ShorLinkRepository $shorLinkRepository)
    {
    }

    /**
     * @param string $url
     * @return \App\Core\Domain\Model\ShortLink
     * @throws \App\Core\Domain\Exception\ShortLinkException
     */
    public function create(string $url): string
    {
        $shortLink = $this->linkGenerator->generate($url);
        $this->shorLinkRepository->save($shortLink);

        return $shortLink->getAlias();
    }
}