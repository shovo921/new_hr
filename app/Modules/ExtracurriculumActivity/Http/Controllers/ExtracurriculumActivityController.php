<?php

namespace App\Modules\ExtracurriculumActivity\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExtracurriculumActivityController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ExtracurriculumActivity::welcome");
    }
}
