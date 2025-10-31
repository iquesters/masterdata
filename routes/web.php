<?php

use Illuminate\Support\Facades\Route;
use Iquesters\Masterdata\Http\Controllers\MasterDataController;
use Iquesters\Masterdata\config\MasterDataConf;

$conf = new MasterDataConf();

Route::middleware($conf->default_values->middlewares[0])->group(function () {
    Route::resource('master-data', MasterDataController::class)->parameters([
        'master-data' => 'master_datum'
    ]);
});