<?php

declare(strict_types=1);

namespace CurrencyConverter;

/**
 * Class CurrencyConvertion
 * @package CurrencyConverter
 */
class CurrencyConvertion
{

    /** @var string */
    protected $currencyFrom;

    /** @var float */
    protected $amountFrom;

    /** @var string */
    protected $currencyTo;

    /** @var float */
    protected $amountTo;

    public function __construct(string $currencyFrom, float $amountFrom, string $currencyTo, float $amountTo = null)
    {
        $this->currencyFrom = $currencyFrom;
        $this->amountFrom = $amountFrom;
        $this->currencyTo = $currencyTo;
        if (!is_null($amountTo)) {
            $this->amountTo = $amountTo;
        }
    }

    /**
     * @return string
     */
    public function getCurrencyFrom(): string
    {
        return $this->currencyFrom;
    }

    /**
     * @return float
     */
    public function getAmountFrom(): float
    {
        return $this->amountFrom;
    }

    /**
     * @return string
     */
    public function getCurrencyTo(): string
    {
        return $this->currencyTo;
    }

    /**
     * @return float
     */
    public function getAmountTo(): float
    {
        return $this->amountTo;
    }

    /**
     * @param float $amountTo
     * @return CurrencyConvertion
     */
    public function setAmountTo(float $amountTo): CurrencyConvertion
    {
        $this->amountTo = $amountTo;

        return $this;
    }

}
