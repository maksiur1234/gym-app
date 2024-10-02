<?php

namespace App\Http\Controllers\SkillTree;

use App\Http\Controllers\Controller;
use App\Models\Exercise\Exercise;
use Illuminate\Http\Request;

class SkillTreeController extends Controller
{
    public function index()
    {
        return view('skill_tree.index');
    }
}
