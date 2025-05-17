<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DanceResource;
use App\Models\Dance;
use Illuminate\Http\Request;

class DanceController extends Controller
{
    public function index() 
    {
        $dances = Dance::paginate(10);

        return new DanceResource(true, 'List Data Tari', $dances);
    }
}
