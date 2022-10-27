<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index() 
    {        
        return Client::get(['id', 'email', 'join_date']);
    }
}
