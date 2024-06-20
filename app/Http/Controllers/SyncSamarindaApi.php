<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SyncSamarindaApi extends Controller
{
    private $apiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBhYWMwYzExZDE2NzAwNGZkOTkwNzg5Y2NkMzc5NmIwZjhiOWQ4ZTI1MTZhMDNmNzBiZDgxNjlkOTFkY2ZmZDFiZDcyNmY1MjlmNzMxMjUyIn0.eyJhdWQiOiIzIiwianRpIjoiMGFhYzBjMTFkMTY3MDA0ZmQ5OTA3ODljY2QzNzk2YjBmOGI5ZDhlMjUxNmEwM2Y3MGJkODE2OWQ5MWRjZmZkMWJkNzI2ZjUyOWY3MzEyNTIiLCJpYXQiOjE3MTg4Njk1NzcsIm5iZiI6MTcxODg2OTU3NywiZXhwIjoxNzUwNDA1NTc3LCJzdWIiOiI4MTUiLCJzY29wZXMiOlsiYmVyaXRha29taW5mbyJdfQ.L1dcll0orXy8POohaYbcb33QB_gxzjDkHjhvSRogT9_rfL701eHd-FWmdRnjCnEQIOmE9UxTLhvM_te2gqmAsxuD92QTzG0Z3TXvf_mdhqE-Q2WoKeU7Y_IbkTjiXXiCz896KFwcctmF8lZPgdr0K-DxkNwcKoZDjUSSfGk8LP8gzAxwH9KLOPwtSU-cGT5PnO71QvN8k9rjTpbLLqQF8GFD8y6U369Ae5IhIRzjv8403bPK7AkyR14Zi5KK_ayI2lZCI0vBkRTMlQviObHHa15538ZgQUPf6M9-i6gTGOWFHTmlFTXGjT-d6KjzjbN1nO94qYUxM5ZHQ4c3KRSTh9T7rNNCfaeSkkSyUbkRVHZPisrd6lR2yYbug_KqEkALWAGB2QGgxQL7_vFh7qWr_oGy3ojJe_V0pjoF4BXWArrMUexc2qP2KsGGABOR9Fnycj2YgrB_GwL-bq1LnjQaxlZCzbtp0a4LBojvy4i2nNTIBwNw-pTrgRfSnY_ktTbpEqW9xE7pqqGxWIbTl9Hwef8ARth5Bjsr1NE6vYc_9aTfVe3szFoSU3KGwTPoO5goz7g7Rgjz8X8xtj59DCJu1O4pOEvhjJuTmjPYWJr6rravXsjiXZflE8_XHHmxEK1aG35c0lzlYZjjiBCLiCwg3vTuxaudgTmWFrXB0Lt72SI';

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get(
            'http://api.samarindakota.go.id/api/v2/generate/ppid-samarinda/berita_ppid'
        );

        if ($response->failed()) {
            return response()->json($response->json(), $response->status());
        }

        $data = $response->json();

        foreach ($data as $item) {
            $news = News::where('slug', $item['slug'])->first();

            if (!$news) {
                News::create([
                    'slug' => $item['slug'],
                    'isi' => $item['isi'],
                ]);
            }
        }

        return response()->json(true);
    }
}
