<?php

namespace App\Http\Resources\Lecture;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'topic' => $this->topic,
            'description' => $this->description,
            'past_students' => $this->pastStudents->pluck('name'),
            'past_groups' => $this->pastGroups->pluck('name')
        ];
    }
}
