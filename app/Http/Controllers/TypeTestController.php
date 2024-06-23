<?php

namespace App\Http\Controllers;

use App\Models\SavedText;
use App\Models\TypeResult;
use Illuminate\Http\Request;
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

        if(isset(TypeResult::latest('id')->first()->result)) {
           $latest_type_result_speed = TypeResult::latest('id')->first()->result;
        }
        else {
            $latest_type_result_speed = 0;
        }

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

        $saved_texts = SavedText::where('user_id', auth::user()['id'])
            ->get(['id', 'text', 'text_name', 'best_speed']);

        $name = auth()->user();

        return view('type', compact('resultsArray', 'saved_texts', 'textToSetInInputTextBox', 'textToCompare', 'bShouldStartTimer', 'name', 'idOfSavedText', 'bShowDialogBoxWithResult', 'dialogBoxContent', 'savedText', 'savedTextName', 'bestSpeed', 'savedTextID', 'updateInfo', 'previousBestSpeed', 'latest_type_result_speed'));
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

    public function savedTexts()
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

        $saved_texts = SavedText::where('user_id', auth::user()['id'])
            ->get(['id', 'text', 'text_name', 'best_speed']);

        return view('savedTexts', compact('saved_texts' , 'textToSetInInputTextBox'));
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
            }
        }

        TypeResult::create([
            'result' => $data['outputSpeed'],
            'username' => auth()->user()['name'],
            'user_id' => auth()->user()['id'],
            'number_of_mistakes' => $data['numberOfMistakes'],
            'user_local_time' => 'time'
        ]);

        return redirect()->route("TypeTestControllerPost.type");
    }

    public function deleteSavedText(Request $request)
    {
        $buttonValue = $request->request->get('saved_text_delete_btn');

        SavedText::destroy($buttonValue);

        return redirect()->route("TypeTestController.savedTexts");
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

//        Session::put('idOfSavedText', $data['savedTextID']);

//        if ($data['savedTextID'] !== null) {
//            Session::put('bUpdateMode', true);
//        }

        Session::put('bUpdateMode', true);

        $saved_text = SavedText::create([
            'text' => $data['inputTextBox'],
            'text_name' => $data['savedTextName'],
            'user_id' => auth()->user()['id']
        ]);

        Session::put('idOfSavedText', $saved_text['id']);

        Session::put('textToCompare', $data['inputTextBox']);
        Session::put('bShouldStartTimer', true);

        return redirect()->route("TypeTestController.savedTexts");
    }
}
