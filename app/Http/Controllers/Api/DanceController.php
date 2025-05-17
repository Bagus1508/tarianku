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

    public function show($id)
    {
        $dance = Dance::find($id);

        $data = [
            ...$dance->toArray(),
            'attachment1' => transformedUrlAttachment($dance->attachment1),
            'attachment2' => transformedUrlAttachment($dance->attachment2),
        ];

        return new DanceResource(true, 'Detail Data Tari', $data);
    }
}
