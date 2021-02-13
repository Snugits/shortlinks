<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Model\ShortLink;

interface ShorLinkRepository
{
    public function getShortLinksCountByAlias(string $alias): int;

    public function save(ShortLink $shortLink): void;

    public function findOneBy(array $criteria, array $orderBy = null);

    public function remove(ShortLink $shortLink): void;
}