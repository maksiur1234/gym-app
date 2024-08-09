<?php

namespace App\Models\User;

use App\Models\TrainingPlan\TrainingPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrainingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_plan_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainingPlan()
    {
        return $this->belongsTo(TrainingPlan::class);
    }
}
