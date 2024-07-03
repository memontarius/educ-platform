<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreRequest;
use App\Http\Requests\Student\UpdateRequest;
use App\Http\Resources\Student\DetailedResource;
use App\Http\Resources\Student\ShowResource;
use App\Models\Student;
use App\Services\ModelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $students = ($request->input('mode') === 'detail')
            ? DetailedResource::collection(Student::with('group')->orderBy('id')->get())
            : Student::orderBy('id')->get()->pluck('name');

        $response = $this->responseBuilder->success()->payload($students)->get();

        return response()->json($response);
    }

    public function show(Student $student): JsonResponse
    {
        $response = $this->responseBuilder->success()->payload(new ShowResource($student))->get();
        return response()->json($response);
    }

    public function store(StoreRequest $request, ModelService $modelService): JsonResponse
    {
        $student = new Student($request->validated());

        $response = $modelService->saveModel($student,$this->responseBuilder,function ($student) {
            return new DetailedResource($student);
        });

        return response()->json($response);
    }

    public function update(int $student, UpdateRequest $request, ModelService $modelService): JsonResponse
    {
        $response = $modelService->updateModelWithTransaction(Student::class, $student,
            $this->responseBuilder, $request->validated());
        return response()->json($response);
    }

    public function destroy(Student $student, ModelService $modelService): JsonResponse
    {
        $response = $modelService->destroyModel($student,$this->responseBuilder);
        return response()->json($response);
    }
}
