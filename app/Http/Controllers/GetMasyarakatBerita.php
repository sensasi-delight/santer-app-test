<?php

namespace App\Http\Controllers;

use App\Models\News;

class GetMasyarakatBerita extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return response()->json(News::all());
    }
}
