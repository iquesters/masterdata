<?php

use Illuminate\Support\Facades\Route;
use Iquesters\Masterdata\Http\Controllers\MasterDataController;

Route::middleware(config('masterdata.middleware'))->group(function () {
    Route::resource('master-data', MasterDataController::class)->parameters([
        'master-data' => 'master_datum'
    ]);
});