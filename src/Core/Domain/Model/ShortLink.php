<?php

namespace App\Core\Domain\Model;

use App\Infrastructure\Persistence\Doctrine\Repository\ShortLinkRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=ShortLinkRepository::class)
 * @ORM\Table("short_links")
 */
final class ShortLink implements JsonSerializable
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

    public function getUrl(): string
    {
        return $this->url;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'alias' => $this->alias,
            'url' => $this->url,
        ];
    }
}
