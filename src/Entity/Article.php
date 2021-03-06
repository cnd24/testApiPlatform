<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *          "article_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true,
 *     ),
 *     exclusion = @Hateoas\Exclusion( groups = {"list", "detail"} )
 * )
 *
 * @Hateoas\Relation(
 *     "create",
 *     href = @Hateoas\Route(
 *          "article_create",
 *          absolute = true,
 *     ),
 *     exclusion = @Hateoas\Exclusion( groups = {"list", "detail"} )
 * )
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list", "detail"})
     *
     * @Serializer\Since("1.0")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"list", "detail"})
     *
     * @Serializer\Since("1.0")
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"list", "detail"})
     *
     * @Serializer\Since("2.0")
     */
    private $shortDescription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}
