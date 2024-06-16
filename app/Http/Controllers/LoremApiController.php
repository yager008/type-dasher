<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoremApiController extends Controller
{
    public function index()
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

        return redirect()->route('TypeTestController.type');
    }
}
