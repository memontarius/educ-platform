<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curriculum\UpdateCurriculumRequest;
use App\Http\Requests\Group\StoreRequest;
use App\Http\Requests\Group\UpdateRequest;
use App\Http\Resources\Group\IndexResource;
use App\Http\Resources\Group\ShowResource;
use App\Http\Resources\Group\StoreResource;
use App\Models\Group;
use App\Services\ModelService;
use Illuminate\Http\JsonResponse;

class GroupController extends Controller
{
    public function index(): JsonResponse
    {
        $groups = Group::all();
        $response = $this->responseBuilder
            ->success()
            ->payload(IndexResource::collection($groups))
            ->get();

        return response()->json($response);
    }

    public function show(int $groupId): JsonResponse
    {
        $group = Group::findOrFail($groupId);
        $response = $this->responseBuilder->success()->payload(new ShowResource($group))->get();

        return response()->json($response);
    }

    public function store(StoreRequest $request, ModelService $modelService): JsonResponse
    {
        $group = new Group($request->validated());

        $response = $modelService->saveModel($group, $this->responseBuilder, function ($group) {
            return new StoreResource($group);
        });

        return response()->json($response);
    }

    public function update(Group $group, UpdateRequest $request, ModelService $modelService): JsonResponse
    {
        $response = $modelService->updateModel($group, $this->responseBuilder, $request->validated());
        return response()->json($response);
    }

    public function destroy(Group $group, ModelService $modelService): JsonResponse
    {
        $response = $modelService->destroyModel($group, $this->responseBuilder);
        return response()->json($response);
    }
}
