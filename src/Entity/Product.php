<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements Stringable
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categoryName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sku = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortdesc = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $caffeineType = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $count = null;

    #[ORM\Column(nullable: true)]
    private ?bool $flavored = null;

    #[ORM\Column(nullable: true)]
    private ?bool $seasonal = null;

    #[ORM\Column(nullable: true)]
    private ?bool $instock = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $facebook = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $isKCup = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(?string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getShortdesc(): ?string
    {
        return $this->shortdesc;
    }

    public function setShortdesc(?string $shortdesc): static
    {
        $this->shortdesc = $shortdesc;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCaffeineType(): ?string
    {
        return $this->caffeineType;
    }

    public function setCaffeineType(?string $caffeineType): static
    {
        $this->caffeineType = $caffeineType;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function isFlavored(): ?bool
    {
        return $this->flavored;
    }

    public function setFlavored(?bool $flavored): static
    {
        $this->flavored = $flavored;

        return $this;
    }

    public function isSeasonal(): ?bool
    {
        return $this->seasonal;
    }

    public function setSeasonal(?bool $seasonal): static
    {
        $this->seasonal = $seasonal;

        return $this;
    }

    public function isInstock(): ?bool
    {
        return $this->instock;
    }

    public function setInstock(?bool $instock): static
    {
        $this->instock = $instock;

        return $this;
    }

    public function getFacebook(): ?int
    {
        return $this->facebook;
    }

    public function setFacebook(?int $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getIsKCup(): ?int
    {
        return $this->isKCup;
    }

    public function setIsKCup(?int $isKCup): static
    {
        $this->isKCup = $isKCup;

        return $this;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return "Id: {$this->id}, CategoryName: {$this->categoryName}, SKU: {$this->sku}, Name: {$this->name}, Description: {$this->description}, ShortDesc: {$this->shortdesc}, Price: {$this->price}, Link: {$this->link}, Image: {$this->image}, Brand: {$this->brand}, Rating: {$this->rating}, CaffeineType: {$this->caffeineType}, Count: {$this->count}, Flavored: {$this->flavored}, Seasonal: {$this->seasonal}, Instock: {$this->instock}, Facebook: {$this->facebook}, IsKCup: {$this->isKCup}";
    }
}
