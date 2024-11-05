<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::apiResource('companies', CompanyController::class);

Route::fallback(function (){
    abort(404, 'API resource not found');
});
