<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $serviceTypes = [
            [
                'id'    => 1,
                'service_type' => 'Internet & Cloud Connectivity Service',
            ],
            [
                'id'    => 2,
                'service_type' => 'Branch office and campus connectivity',
            ],
            [
                'id'    => 3,
                'service_type' => 'Virtual network services',
            ],
            [
                'id'    => 4,
                'service_type' => 'Secure cloud-connectivity services',
            ],
            [
                'id'    => 5,
                'service_type' => 'Private data center services',
            ],

        ];
        ServiceType::insert($serviceTypes);
    }
}
