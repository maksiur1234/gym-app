<?php

namespace App\Models\TrainingPlan;

use App\Models\Exercise\Exercise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingDayExercise extends Model
{
    use HasFactory;

    protected $table = 'training_day_exercises';

    protected $fillable = [
        'training_day_id',
        'exercise_id',
        'sets',
        'reps',
        'rir',
        'tempo',
        'break'
    ];

    public function trainingDay()
    {
        return $this->belongsTo(TrainingDay::class);
    }
    public function exercise()
    {
        $this->belongsTo(Exercise::class);
    }
}
