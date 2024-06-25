<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoremApiController extends Controller
{
    public function index(Request $request)
    {
        $ch_req = curl_init("https://api.api-ninjas.com/v1/loremipsum?paragraphs=1?max_length=1");
        curl_setopt($ch_req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_req, CURLOPT_HTTPHEADER, [
            'X-Api-Key: gVnLRxodHjnwJFa+AHSf0A==Q6ghu5Rq6TwJDkIq'
        ]);

        $response = curl_exec($ch_req);
        $response = json_decode($response, true);
        $stringResponse =  $response['text'];
        $stringResponse = str_replace("’", "'", $stringResponse);
        $stringResponse = str_replace("‘", "'", $stringResponse);
        $stringResponse = str_replace("“", '"', $stringResponse);
        $stringResponse = str_replace("”", '"', $stringResponse);
        $stringResponse = str_replace(".", '. ', $stringResponse);
        $stringResponse = str_replace(",", ', ', $stringResponse);
        $stringResponse = str_replace(";", '; ', $stringResponse);
        $stringResponse = str_replace("  ", ' ', $stringResponse);
        $stringResponse = str_replace("—", '-', $stringResponse);
        $stringResponse = str_replace("?I", '? I', $stringResponse);

        echo "<div id='loremResponse' >{$stringResponse}</div>";

        $loremApiResponse = $stringResponse;
        Session::put('loremApiResponse', $loremApiResponse);

        // Get the HTTP referrer
        $referrer = $request->header('referer');

        // Initialize an array to hold query parameters
        $queryParams = [];

        if ($referrer) {
            // Parse the URL to get components
            $urlComponents = parse_url($referrer);

            // Check if there is a query string in the referrer URL
            if (isset($urlComponents['query'])) {
                // Parse the query string into an associative array
                parse_str($urlComponents['query'], $queryParams);
            }
        }

        return redirect()->route('TypeTestController.savedTexts', $queryParams);
    }
}
