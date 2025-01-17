<?php

namespace App\Services;

use App\Common\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelService
{
    public function saveModel(Model $model, ResponseBuilder &$responseBuilder, \Closure $getPayload): array
    {
        if ($model->save()) {
            $responseBuilder->success()->payload($getPayload($model));
        }
        else {
            $class = get_class($model);

            $responseBuilder->failed()->errors([
                "Failed to save the model to database. Model: {$class}"
            ]);
        }

        return $responseBuilder->get();
    }

    public function updateModel(Model $model, ResponseBuilder &$responseBuilder, array $data): array
    {
        if ($model->update($data)) {
            $responseBuilder->success();
        }
        else {
            $class = get_class($model);

            $responseBuilder->failed()->errors([
                'errors' => "Failed to update the model to database. Model: {$class}"
            ]);
        }

        return $responseBuilder->get();
    }

    public function destroyModel(Model $model, ResponseBuilder &$responseBuilder): array
    {
        try {
            $model->delete();
            $responseBuilder->success();
        } catch (\LogicException $e) {
            $responseBuilder->failed()->errors(['errors' => $e->getMessage()]);
        }

        return $responseBuilder->get();
    }

    public function updateModelWithTransaction(string $modelClass, int $id, ResponseBuilder &$responseBuilder, array $data): array
    {
        try {
            DB::beginTransaction();

            /** @var Model $model */
            $model = $modelClass::lockForUpdate()->find($id);
            $this->updateModel($model, $responseBuilder, $data);

            DB::commit();
        }
        catch (\Exception $exception) {
            DB::rollBack();
            $responseBuilder->failed()->errorAsString($exception->getMessage());
        }

        return $responseBuilder->get();
    }
}
