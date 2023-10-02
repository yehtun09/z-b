<?php

namespace Database\Seeders;

use App\Models\ServicePlan;
use Illuminate\Database\Seeder;

class ServicePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $servicePlans = [
            [
                'id'    => 1,
                'service_plan'  => 'Mobile Phone Plan',
            ],
            [
                'id'    => 2,
                'service_plan'  => 'Internet Broadband Plans',
            ],
            [
                'id'    => 3,
                'service_plan'  => 'Home Phone Plans',
            ],
            [
                'id'    => 4,
                'service_plan'  => 'Business Network Plans',
            ],
            [
                'id'    => 5,
                'service_plan'  => 'Family Plans',
            ],
            [
                'id'    => 6,
                'service_plan'  => 'Pay-As-You-Go Plans',
            ],
        ];

        ServicePlan::insert($servicePlans);
    }
}
