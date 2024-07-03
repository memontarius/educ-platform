<?php

namespace App\Http\Controllers;


use App\Http\Requests\Lecture\StoreRequest;
use App\Http\Requests\Lecture\UpdateRequest;
use App\Http\Resources\Lecture\ShowResource;
use App\Models\Lecture;
use App\Services\ModelService;
use Illuminate\Http\JsonResponse;

class LectureController extends Controller
{
    public function index(): JsonResponse
    {
        $groups = Lecture::orderBy('id')->get();
        $response = $this->responseBuilder
            ->success()
            ->payload($groups->pluck('topic'))
            ->get();

        return response()->json($response);
    }

    public function show(int $lectureId): JsonResponse
    {
        $group = Lecture::findOrFail($lectureId);
        $response = $this->responseBuilder
            ->success()
            ->payload(new ShowResource($group))
            ->get();

        return response()->json($response);
    }

    public function store(StoreRequest $request, ModelService $modelService): JsonResponse
    {
        $lecture = new Lecture($request->validated());

        $response = $modelService->saveModel($lecture, $this->responseBuilder, function ($lecture) {
            return ['id' => $lecture->id];
        });

        return response()->json($response);
    }

    public function update(Lecture $lecture, UpdateRequest $request, ModelService $modelService): JsonResponse
    {
        $response = $modelService->updateModel($lecture, $this->responseBuilder, $request->validated());
        return response()->json($response);
    }

    public function destroy(Lecture $lecture, ModelService $modelService): JsonResponse
    {
        $response = $modelService->destroyModel($lecture, $this->responseBuilder);
        return response()->json($response);
    }
}
