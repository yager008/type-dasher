<?php

namespace App\Http\Controllers;

use App\Models\SavedText;
use App\Models\TypeResult;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TypeTestController extends Controller
{

    public function exitSavedTextMode()
    {
        Session::remove('savedText');
        Session::remove('savedTextName');
        Session::remove('bestSpeed');
        Session::remove('savedTextID');
        Session::remove('previousBestSpeed');

        return redirect()->route("TypeTestControllerPost.type");
    }


    public function type()
    {
        session_start();

        $textToCompare = Session::get('textToCompare');
        $bibleApiResponse = Session::get('bibleApiResponse');
        $loremApiResponse = Session::get('loremApiResponse');
        $idOfSavedText = Session::get('idOfSavedText');
        $bFromStoreResult = Session::get('bFromStoreResult');

        //if redirect from TypeTestController.saveText
        $bSavedTextUpdate = Session::get('bSavedTextUpdate');
        $previousBestSpeed = Session::get('previousBestSpeed');
        $bUpdateMode = Session::get('bUpdateMode');

        if ($bUpdateMode) {
            $updateInfo = 'in saved_text mode';
            Session::put('bUpdateMode', false);
        } else {
            $updateInfo = 'not in saved_text mode';
            Session::put('bUpdateMode', false);
        }

        Session::put('bSavedTextUpdate', false);

        //if redirected from TypeTestController.openSavedText
        $savedText= Session::get('savedText');
        $savedTextName = Session::get('savedTextName');
        $bestSpeed = Session::get('bestSpeed');
        $savedTextID = Session::get('savedTextID');

        $latest_type_result_speed = '---';
        $latest_type_result_number_of_mistakes = '---';


//        if(isset(TypeResult::latest('id')->first()->result)) {
//           $latest_type_result_speed = TypeResult::latest('id')->first()->result;
//        }
//        else {
//            $latest_type_result_speed = '---';
//        }
//        if(isset(TypeResult::latest('id')->first()->number_of_mistakes)) {
//            $latest_type_result_number_of_mistakes = TypeResult::latest('id')->first()->number_of_mistakes;
//        }
//        else {
//            $latest_type_result_number_of_mistakes = '---';
//        }

        if ($bSavedTextUpdate) {
//            Session::remove('savedText');
//            Session::remove('bestSpeed');
//            Session::remove('savedTextID');
//            Session::remove('previousBestSpeed');

            if ($previousBestSpeed < $latest_type_result_speed) {
                $dialogBoxContent = "savedTextId: " . $savedTextID . " " . "previousBestSpeed" . $previousBestSpeed . " " . "yourSpeed: " . $latest_type_result_speed . "CONGRATS!!!";
            } else if ($previousBestSpeed > $latest_type_result_speed) {
                $dialogBoxContent = "savedTextId: " . $savedTextID . " " . "previousBestSpeed" . $previousBestSpeed . " " . "yourSpeed: " . $latest_type_result_speed . ":(((((((";
            } else {
                $dialogBoxContent = "savedTextId: " . $savedTextID . " " . "previousBestSpeed" . $previousBestSpeed . " " . "yourSpeed: " . $latest_type_result_speed . "EQUAL!!!";

            }

            $bShowDialogBoxWithResult = true;
        } else if ($bFromStoreResult) {
            $dialogBoxContent = $latest_type_result_speed;
            $bShowDialogBoxWithResult = true;
        } else {
            $dialogBoxContent = "NOT from store result";
            $bShowDialogBoxWithResult = false;
        }

        $textToSetInInputTextBox = '';

        if (isset($bibleApiResponse)) {
            $textToSetInInputTextBox = $bibleApiResponse;
        } else if (isset($loremApiResponse)) {
            $textToSetInInputTextBox = $loremApiResponse;
        } else if (isset($savedText)) {
            $textToSetInInputTextBox = $savedText;
        }

        $bShouldStartTimer = Session::get('bShouldStartTimer');

        Session::remove('bibleApiResponse');
        Session::remove('loremApiResponse');
        Session::remove('bShouldStartTimer');
        Session::remove('idOfSavedText');
        Session::remove('bFromStoreResult');

        // $type_results = type_result::pluck('result')->toArray();

        $type_results = TypeResult::where('user_id', auth::user()['id'])
            ->get(['updated_at', 'result', 'number_of_mistakes']);

        // Transform the results into an associative array
        $resultsArray = $type_results->map(function ($item) {
            return [
//                'updated_at' => date('H:i:s d.m.Y', $item->updated_at->timestamp),
                'updated_at' => Carbon::parse($item->updated_at)->timezone(auth()->user()['timezone'])->toDateTimeString(),
                'result' => $item->result,
                'number_of_mistakes' => $item->number_of_mistakes
            ];

        })->toArray();

        $numberOfMistakesForBestTypeResult = 0;
        $bestSpeedForTypeResult = 0;
        if(isset($savedTextID)) {
            if (SavedText::find($savedTextID)->best_type_result_id != -1) {
                $numberOfMistakesForBestTypeResult = TypeResult::find(SavedText::find($savedTextID)->best_type_result_id)->number_of_mistakes;
            }

            if (SavedText::find($savedTextID)->best_type_result_id != -1) {
                $bestSpeedForTypeResult = TypeResult::find(SavedText::find($savedTextID)->best_type_result_id)->result;
            }
        }

        $name = auth()->user();

        return view('type', compact('resultsArray',  'textToSetInInputTextBox', 'textToCompare', 'bShouldStartTimer', 'name', 'idOfSavedText', 'bShowDialogBoxWithResult', 'dialogBoxContent', 'savedText', 'savedTextName', 'bestSpeed', 'savedTextID', 'updateInfo', 'previousBestSpeed', 'latest_type_result_speed' , 'numberOfMistakesForBestTypeResult' , 'latest_type_result_number_of_mistakes', 'bestSpeedForTypeResult'));
    }

    public function statistics()
    {

        // $type_results = type_result::pluck('result')->toArray();
        $type_results = TypeResult::where('user_id', auth::user()['id'])
            ->get(['updated_at', 'result', 'number_of_mistakes']);

        // Transform the results into an associative array
        $resultsArray = $type_results->map(function ($item) {
            return [
//                'updated_at' => date('H:i:s d.m.Y', $item->updated_at->timestamp),
                'updated_at' => Carbon::parse($item->updated_at)->timezone(auth()->user()['timezone'])->toDateTimeString(),
                'result' => $item->result,
                'number_of_mistakes' => $item->number_of_mistakes
            ];

        })->toArray();

        return view('charts', compact('resultsArray'));
    }

    public function savedTexts(Request $request)
    {
        $bibleApiResponse = Session::get('bibleApiResponse');
        $loremApiResponse = Session::get('loremApiResponse');

        Session::remove('bibleApiResponse');
        Session::remove('loremApiResponse');

        $textToSetInInputTextBox = '';

        if (isset($bibleApiResponse)) {
            $textToSetInInputTextBox = $bibleApiResponse;
        } else if (isset($loremApiResponse)) {
            $textToSetInInputTextBox = $loremApiResponse;
        } else if (isset($savedText)) {
            $textToSetInInputTextBox = $savedText;
        }


        $saved_texts = SavedText::where('user_id', auth()->user()->id)->get();

// Loop through each saved text and add the 'number_of_mistakes_for_best_type_result' field
        foreach ($saved_texts as $saved_text) {
            $saved_text->number_of_mistakes_for_best_type_result = 0; // Default value

            if ($saved_text->best_type_result_id != -1) {
                $bestTypeResult = TypeResult::find($saved_text->best_type_result_id);
                if ($bestTypeResult) {
                    $saved_text->number_of_mistakes_for_best_type_result = $bestTypeResult->number_of_mistakes;
                }
            }

            $saved_text->is_create_form = false;
        }

        $pseudo_item = [
            'id' => null,
            'text' => '',
            'best_speed' => '',
            'text_name' => '',
            'is_create_form' => true, // Flag to identify this pseudo item
            'number_of_mistakes_for_best_type_result' => null, // Pseudo item should not have mistakes
        ];

        $saved_texts->push((object)$pseudo_item);


        // Manually paginate the collection
        $perPage = 6;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $saved_texts->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedSavedTexts = new LengthAwarePaginator(
            $currentPageItems,
            $saved_texts->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('savedTexts', compact('paginatedSavedTexts', 'textToSetInInputTextBox'));
    }


    public function storeResult(Request $request)
    {
        Session::start();

        Session::put('bFromStoreResult', 'true');

        $data = request()->validate([
            "timer" => 'string',
            "numberOfMistakes" => 'nullable|string',
            "outputSpeed" => 'string',
            "savedTextId" => 'required_with:savedTextId'
        ]);

        $data['numberOfMistakes'] = $data['numberOfMistakes'] ?? '0';

        $latest_type_result = TypeResult::create([
            'result' => $data['outputSpeed'],
            'username' => auth()->user()['name'],
            'user_id' => auth()->user()['id'],
            'number_of_mistakes' => $data['numberOfMistakes'],
            'user_local_time' => 'time'
        ]);

        if ($data['savedTextId'] !== null) {
            Session::put('bSavedTextUpdate', 'true');

            $savedText = SavedText::find($data['savedTextId']);

            $currentBestSpeed = $savedText->best_speed;
            $numberOfMistakes = $savedText->number_of_mistakes;
            Session::put('previousBestSpeed', $currentBestSpeed);
            Session::put('numberOfMistakes', $numberOfMistakes);

            if ($data['outputSpeed'] > $currentBestSpeed) {
                // If the new speed is better, update the record with the new best speed
                $savedText->update(['best_speed' => $data['outputSpeed']]);
                $savedText->best_type_result_id = $latest_type_result->id;
                $savedText->save();
            }
        }


        return redirect()->route("TypeTestControllerPost.type");
    }

    public function deleteSavedText(Request $request)
    {
        $buttonValue = $request->request->get('saved_text_delete_btn');

        SavedText::destroy($buttonValue);

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

        return redirect()->route("TypeTestController.savedTexts", $queryParams);
    }

    public function updateSavedText(Request $request)
    {
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

        $data = request()->validate([
            "savedTextID" => 'int',
            "savedText" => 'string',
            "updatedText" => 'string',
        ]);

        $savedText = SavedText::find($data['savedTextID']);

        $savedText->update(['text'=> $data['updatedText']]);
        $savedText->save();

        return redirect()->route("TypeTestController.savedTexts", $queryParams);
    }

    public function openSavedText(Request $request)
    {
        $data = request()->validate([
            "bestSpeed" => 'string',
            "savedTextID" => 'string',
            "savedText" => 'string',
            "savedTextName" => 'string'
        ]);

        Session::start();

        Session::put('savedTextID', $data['savedTextID']);
        Session::put('savedText', $data['savedText']);
        Session::put('savedTextName', $data['savedTextName']);
        Session::put('bestSpeed', $data['bestSpeed']);
        Session::put('idOfSavedText', $data['savedTextID']);

        if ($data['savedTextID'] !== null) {
            Session::put('bUpdateMode', true);
        }

        Session::put('textToCompare', $data['savedText']);
        Session::put('bShouldStartTimer', true);

        return redirect()->route("TypeTestControllerPost.type");
    }

    public static function storeSavedTextIfCheckboxIsOn(Request $request)
    {
        Session::start();

        $data = request()->validate([
            "inputTextBox" => 'string',
            'checkbox' => 'required_with:checkbox',
            'savedTextName' => 'required_with:checkbox',
            'savedTextID' => 'required_with:Id',
        ]);

        Session::put('idOfSavedText', $data['savedTextID']);

        if ($data['savedTextID'] !== null) {
            Session::put('bUpdateMode', true);
        }

        if (isset($data['checkbox'])) {
            Session::put('bUpdateMode', true);

            $saved_text = SavedText::create([
                'text' => $data['inputTextBox'],
                'text_name' => $data['savedTextName'],
                'user_id' => auth()->user()['id']
            ]);

            Session::put('idOfSavedText', $saved_text['id']);
        }

        Session::put('textToCompare', $data['inputTextBox']);
        Session::put('bShouldStartTimer', true);

        return redirect()->route("TypeTestController.type");
    }

    public static function createText(Request $request)
    {
        Session::start();

        $data = request()->validate([
            "inputTextBox" => 'string',
            'savedTextName' => 'string'
        ]);

        dd($data['inputTextBox']);

//        Session::put('idOfSavedText', $data['savedTextID']);

//        if ($data['savedTextID'] !== null) {
//            Session::put('bUpdateMode', true);
//        }

        Session::put('bUpdateMode', true);

        $saved_text = SavedText::create([
            'text' => $data['inputTextBox'],
            'text_name' => $data['savedTextName'],
            'user_id' => auth()->user()['id'],
            'best_type_result_id' => -1
        ]);

        Session::put('idOfSavedText', $saved_text['id']);

        Session::put('textToCompare', $data['inputTextBox']);
        Session::put('bShouldStartTimer', true);

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

        return redirect()->route("TypeTestController.savedTexts", $queryParams);
    }
}
