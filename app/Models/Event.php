<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillble = [
        'name',
        'date',
        'time',
        'location',
        'help_num',
        'attend_num',
        'attend_points',
        'content',
        'image'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(EventUser::class)
            ->withTimeStamps()
            ->withPivot('user_role');
    }
}
