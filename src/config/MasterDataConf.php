<?php

namespace Iquesters\MasterData\config;

use Iquesters\Foundation\Support\BaseConf;
use Iquesters\Foundation\Enums\Module;

class MasterDataConf extends BaseConf
{
    protected ?string $identifier = Module::MASTER_DATA;

    protected string $layout; 
    protected array $middlewares;
    

    protected function prepareDefault(BaseConf $default_values)
    {
        $default_values->layout = 'masterdata::layouts.package';
        $default_values->middlewares = ['web', 'auth'];
        
    }
}