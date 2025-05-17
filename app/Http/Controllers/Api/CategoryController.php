<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Categories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Categories::all()->map(function ($item) {
            return [
                "id"          => $item->id,
                "name"        => $item->name,
                "created_at"  => $item->created_at,
                "updated_at"  => $item->updated_at,
                "deleted_at"  => $item->deleted_at,
                "attachment"  => transformedUrlAttachment($item->attachment),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Berhasil Ditampilkan',
            'data'    => $categories,
        ]);
    }
}
