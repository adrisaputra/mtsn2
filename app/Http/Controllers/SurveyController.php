<?php

namespace App\Http\Controllers;

use App\Models\Survey;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class SurveyController extends Controller
{
    ## Tampikan Data
    public function index()
    {
        $title = "Survey Penilaian";
        $survey = Survey::orderBy('id', 'DESC')->paginate(25)->onEachSide(1);
        return view('survey.index', compact('title', 'survey'));
    }

    ## Tampikan Data
    public function thanks()
    {
        $title = "Survey Penilaian";
        return view('survey.thanks', compact('title'));
    }

    ## Simpan Data
    public function store($survey)
    {
		$input['survey'] = $survey;
        Survey::create($input);
        
        activity()->log('Tambah Data Survey');
		return redirect('/survey/thanks')->with('status','Survey Kepuasan Disimpan');
    }
}
