<?php

namespace App\Services\Contracts;

interface ApiInterface
{
    public function getHistoricalData();
    public function getMappedData();
}
