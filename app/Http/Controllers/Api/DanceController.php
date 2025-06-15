<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DanceResource;
use App\Models\Categories;
use App\Models\Dance;
use Illuminate\Http\Request;

class DanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('origin_id')) {
            $dances = Dance::where('categories_id', $request->origin_id)->paginate(10);
            $origin = Categories::find($request->origin_id)?->name;
        } else {
            $dances = Dance::paginate(10);
            $origin = 'All';
        }

        return new DanceResource(true, 'List Data Tari', [
            'origin_id' => $request->origin_id ?? null,
            'origin' => $origin ?? null,
            'data' => $dances,
        ]);
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
