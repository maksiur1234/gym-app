<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'roles';

    protected $fillable = [
      'id',
      'name',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
