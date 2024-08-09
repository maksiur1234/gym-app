<?php

namespace App\Models\TrainingPlan;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $table = 'training_plans';

    protected $fillable = [
        'name',
        'desc',
        'created_by',
        'user_id',
    ];

}
