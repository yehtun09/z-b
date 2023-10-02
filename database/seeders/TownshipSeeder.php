<?php

namespace Database\Seeders;

use App\Models\Township;
use Illuminate\Database\Seeder;

class TownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $townships = [
            [
                'id'       => 1,
                'township' => 'Bahan',
            ],
            [
                'id'       => 2,
                'township' => 'South Okkalapa',
            ],
            [
                'id'       => 3,
                'township' => 'Hlaing',
            ],
            [
                'id'       => 4,
                'township' => 'Kamayut',
            ],
            [
                'id'       => 5,
                'township' => 'Dagon',
            ],
            [
                'id'       => 6,
                'township' => 'Kyauktada',
            ],
            [
                'id'       => 7,
                'township' => 'Mayangon',
            ],
            [
                'id'       => 8,
                'township' => 'Botataung',
            ],
            [
                'id'       => 9,
                'township' => 'Sanchaung',
            ],
            [
                'id'       => 10,
                'township' => 'Kyauktada',
            ],
        ];

        Township::insert($townships);
    }
}
