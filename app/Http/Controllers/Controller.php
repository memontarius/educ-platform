<?php

namespace App\Http\Controllers;

use App\Common\ResponseBuilder;
use Illuminate\Support\Facades\DB;

abstract class Controller
{
    protected ResponseBuilder $responseBuilder;

    public function __construct()
    {
        $this->responseBuilder = app()->make(ResponseBuilder::class);
/*
        DB::listen(function($query) {
            dump($query->sql, $query->bindings);
        });*/
    }
}
