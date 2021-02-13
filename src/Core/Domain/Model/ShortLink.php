<?php

namespace App\Core\Domain\Model;

use App\Infrastructure\Persistence\Doctrine\Repository\ShortLinkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShortLinkRepository::class)
 * @ORM\Table("short_links")
 */
class ShortLink
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function __construct(?int $id, string $alias, string $url)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->url = $url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
