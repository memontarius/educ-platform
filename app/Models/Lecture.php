<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'description'
    ];

    public function pastStudents(): MorphToMany
    {
        return $this->morphedByMany(Student::class, 'listenable', 'listened_lectures');
    }

    public function pastGroups(): MorphToMany
    {
        return $this->morphedByMany(Group::class, 'listenable', 'listened_lectures');
    }
}
