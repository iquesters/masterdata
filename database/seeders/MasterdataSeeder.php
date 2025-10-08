<?php

namespace Iquesters\Masterdata\Database\Seeders;

use Iquesters\Foundation\Database\Seeders\BaseModuleSeeder;

class MasterdataSeeder extends BaseModuleSeeder
{
    protected string $moduleName = 'masterdata';
    protected string $description = 'masterdata module';
    protected array $metas = [
        'module_icon' => 'fas fa-database',
        'module_sidebar_menu' => [
            [
                "icon" => "fas fa-list-ul",
                "label" => "All Masterdatas",
                "route" => "master-data.index",
            ]
        ]
    ];
}