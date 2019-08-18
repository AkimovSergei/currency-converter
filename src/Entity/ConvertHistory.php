<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConvertHistoryRepository")
 */
class ConvertHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currency_from;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currency_to;

    /**
     * @ORM\Column(type="float")
     */
    private $amount_from;

    /**
     * @ORM\Column(type="float")
     */
    private $amount_to;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $capital;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyFrom(): ?string
    {
        return $this->currency_from;
    }

    public function setCurrencyFrom(string $currency_from): self
    {
        $this->currency_from = $currency_from;

        return $this;
    }

    public function getCurrencyTo(): ?string
    {
        return $this->currency_to;
    }

    public function setCurrencyTo(string $currency_to): self
    {
        $this->currency_to = $currency_to;

        return $this;
    }

    public function getAmountFrom(): ?float
    {
        return $this->amount_from;
    }

    public function setAmountFrom(float $amount_from): self
    {
        $this->amount_from = $amount_from;

        return $this;
    }

    public function getAmountTo(): ?float
    {
        return $this->amount_to;
    }

    public function setAmountTo(float $amount_to): self
    {
        $this->amount_to = $amount_to;

        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(?string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
