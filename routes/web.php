<?php

use Illuminate\Support\Facades\Route;
use Iquesters\Masterdata\Http\Controllers\MasterDataController;
use Iquesters\Foundation\Support\ConfProvider;
use Iquesters\Foundation\Enums\Module;

$masterdata = ConfProvider::from(Module::MASTER_DATA);

Route::middleware($masterdata->middlewares)->group(function () {
    Route::resource('master-data', MasterDataController::class)->parameters([
        'master-data' => 'master_datum'
    ]);
});