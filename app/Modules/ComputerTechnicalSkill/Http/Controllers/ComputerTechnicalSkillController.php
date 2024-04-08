<?php

namespace App\Modules\ComputerTechnicalSkill\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComputerTechnicalSkillController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ComputerTechnicalSkill::welcome");
    }
}
