<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'group_id'
    ];

    public function group(): HasOne
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function listenedLectures(): MorphToMany
    {
        return $this->morphToMany(Lecture::class, 'listenable', 'listened_lectures');
    }
}
