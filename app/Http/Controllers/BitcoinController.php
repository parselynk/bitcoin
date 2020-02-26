<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\BitcoinInterface;

class BitcoinController extends Controller
{
        protected $bitcoin;

    public function __construct(BitcoinInterface $bitcoin)
    {
        
        $this->bitcoin = $bitcoin;
    }

    public function index()
    {
        dd($this->bitcoin);
    }
}
