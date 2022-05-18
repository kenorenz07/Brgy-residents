<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['residents'];

    public function secretary()
    {
        return $this->belongsTo(User::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

}
