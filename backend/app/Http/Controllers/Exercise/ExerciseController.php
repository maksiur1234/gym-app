<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use App\Models\Exercise\Exercise;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all();

        return response()->json($exercises);
    }
}
