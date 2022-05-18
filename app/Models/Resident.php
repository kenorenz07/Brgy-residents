<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ["full_name"];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function getFullnameAttribute()
    {
        $fullname = '';
        if ($this->first_name) $fullname = ucfirst($this->first_name);
        if ($this->middle_name) $fullname .= ' '. ucfirst($this->middle_name);
        if ($this->last_name) $fullname .= ' '.ucfirst($this->last_name);
        if ($this->suffix) $fullname .= ' '.ucfirst($this->suffix);
        return $fullname;
    }
}
