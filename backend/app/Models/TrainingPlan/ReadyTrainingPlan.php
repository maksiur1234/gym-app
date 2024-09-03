<?php

namespace App\Models\TrainingPlan;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadyTrainingPlan extends Model
{
    use HasFactory;

    protected $table = 'ready_training_plans';

    protected $fillable = [
        'name',
        'desc',
        'created_by',
        'is_public',
        'price',
    ];

    public function trainingDays()
    {
        return $this->hasMany(TrainingDay::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
