<?php
namespace App\Models\Workout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_session_id',
        'exercise_name',
        'sets',
        'reps'   
    ];

    public function workoutSession()
    {
        $this->belongsTo(WorkoutSession::class);
    }
}