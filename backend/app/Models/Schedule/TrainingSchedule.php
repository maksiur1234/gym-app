<?php

namespace App\Models\Schedule;

use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_plan_id',
        'type',
        'day_of_week',
        'specific_date',
        'start_time',
    ];

    public function trainingPlan()
    {
        return $this->belongsTo(TrainingPlan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
