<?php

namespace Iquesters\Masterdata\Database\Seeders;

use Iquesters\Foundation\Database\Seeders\BaseSeeder;

class MasterdataSeeder extends BaseSeeder
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

    protected array $permissions = [
        'view-master_data',
        'create-master_data',
        'edit-master_data',
        'delete-master_data'
    ];
    
    /**
     * Implement abstract method from BaseSeeder
     */
    protected function seedCustom(): void
    {
        // Add custom seeding logic here if needed
        // Leave empty if none
    }
}