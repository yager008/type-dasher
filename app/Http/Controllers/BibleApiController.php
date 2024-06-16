<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SavedText;
use App\Models\typeresult;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BibleApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {

        $response = Http::get('https://bible-api.com/?random=verse');

        $response = json_decode($response, true);
        $stringResponse =  $response['verses']['0']['text'];
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

        $bibleApiResponse = $stringResponse;
        Session::put('bibleApiResponse', $bibleApiResponse);

        return redirect()->route('TypeTestController.type');

//        echo "<div id='bibleResponse' style='display: none'>{$stringResponse}</div>";
//        //+ js before /body that sets inputTextBox ??
    }
}
