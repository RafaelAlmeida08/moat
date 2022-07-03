<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $album_name;

    /**
     * @ORM\Column(type="date")
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist($artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getAlbumName(): ?string
    {
        return $this->album_name;
    }

    public function setAlbumName(string $album_name): self
    {
        $this->album_name = $album_name;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }
}
