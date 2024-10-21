<?php

namespace App\Models\Schedule;

use App\Models\TrainingPlan\TrainingDay;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_day_id',
        'scheduled_date',
    ];

    public function trainingPlan()
    {
        return $this->belongsTo(TrainingPlan::class);
    }

    public function trainingDay()
    {
        return $this->belongsTo(TrainingDay::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
