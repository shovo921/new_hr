<?php

namespace App\Modules\ComputerGeneralSkill\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComputerGeneralSkillController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ComputerGeneralSkill::welcome");
    }
}
