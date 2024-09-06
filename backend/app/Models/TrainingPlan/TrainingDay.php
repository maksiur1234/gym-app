<?php

namespace App\Models\TrainingPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingDay extends Model
{
    use HasFactory;

    protected $table = 'training_days';

    protected $fillable = [
        'training_plan_id',
        'ready_training_plan_id',
        'day_name',
    ];

    public function exercises()
    {
        return $this->hasMany(TrainingDayExercise::class);
    }

    public function trainingPlan()
    {
        return $this->belongsTo(TrainingPlan::class);
    }
    public function readyTrainingPlan()
    {
        return $this->belongsTo(ReadyTrainingPlan::class);
    }
}
