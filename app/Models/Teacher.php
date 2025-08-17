<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
