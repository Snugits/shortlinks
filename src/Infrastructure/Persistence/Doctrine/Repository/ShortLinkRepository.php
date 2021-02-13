<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Core\Domain\Model\ShortLink;
use App\Core\Domain\Repository\ShorLinkRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortLink[]    findAll()
 * @method ShortLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortLinkRepository extends ServiceEntityRepository implements ShorLinkRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortLink::class);
    }

    public function getShortLinksCountByAlias(string $alias): int
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->andWhere('s.alias = :ali')
            ->setParameter('ali', $alias)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function save(ShortLink $shortLink): void
    {
        $this->_em->persist($shortLink);
        $this->_em->flush();
    }
}
