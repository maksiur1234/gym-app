<?php

namespace App\Models\Workout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_plan_id',
        'session_id',
        'total_sets',
        'total_reps',
    ];

    public function exercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_session_id');
    }
}
