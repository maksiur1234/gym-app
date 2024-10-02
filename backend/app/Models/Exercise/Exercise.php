<?php

namespace App\Models\Exercise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $table = 'exercises';

    protected $fillable = [
      'name',
      'desc',
      'level',
      'parent_id',
      'category_id',
      'required_global_level',
      'required_category_level',
      'exercise_type',
    ];

    public function children()
    {
      return $this->hasMany(Exercise::class, 'parent_id')->with('children');
    }

    public function parent()
    {
      return $this->belongsTo(Exercise::class, 'parent_id');
    }
}
