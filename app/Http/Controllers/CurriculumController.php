<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curriculum\UpdateRequest;
use App\Models\Group;
use App\Models\Lecture;
use Illuminate\Http\JsonResponse;

class CurriculumController extends Controller
{
    public function show(Group $group): JsonResponse
    {
        $lectures = $group->lectures()->orderBy('order_number')->get();

        $strippedLectures = $lectures->mapWithKeys(function (Lecture $lecture, int $key) {
            return [$key => [
                'id' => $lecture['id'],
                'topic' => $lecture['topic'],
                'order_number' => $lecture->pivot->order_number,
            ]];
        })->all();

        $response = $this->responseBuilder->success()->payload($strippedLectures)->get();

        return response()->json($response);
    }

    public function update(Group $group, UpdateRequest $request): JsonResponse
    {
        $lectures = collect($request->validated())
            ->keyBy('id')
            ->select(['order_number'])
            ->toArray();

        $group->lectures()->sync($lectures, true);
        $response = $this->responseBuilder->success()->get();

        return response()->json($response);
    }
}
