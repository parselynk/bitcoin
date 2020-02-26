<?php

namespace App\Repositories;

use App\Repositories\Contracts\BitcoinInterface;
use App\Services\GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Carbon\Carbon;

class BitcoinRepository implements BitcoinInterface
{
    protected $http;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->http = $guzzleClient;
    }
}
