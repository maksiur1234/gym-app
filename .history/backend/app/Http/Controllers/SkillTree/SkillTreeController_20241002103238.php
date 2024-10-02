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

    public function skillLevel()
    {
        $tree = Exercise::with('children')
        ->whereNull('parent_id')
        ->get();

        $globalLevel = auth()->user()->global_level;

        return response()->json([
            'tree' => $tree,
            'global_level' => $globalLevel
        ]);
    }
}
