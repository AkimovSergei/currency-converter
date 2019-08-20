<?php

namespace App\Services;


/**
 * Class Helpers
 * @package App\Services
 */
class Helpers
{

    /**
     * Parse money input to float value
     *
     * @param string $amount
     * @return float
     */
    public function parseMoney(string $amount): float
    {
        $amount = str_replace(' ', '', $amount);
        $amount = str_replace(',', '.', $amount);
        $amount = (float)$amount;

        return $amount;
    }

}
