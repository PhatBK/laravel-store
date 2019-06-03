<?php

use Illuminate\Database\Seeder;
use App\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrManuf = ['Cort', 'Fernandes', 'Epiphone', 'Fender', ];
        // $arrType = ['bass', 'acoustic', 'electric', ];
        $arrMaterial = ['Basswood', 'Maple', 'Birch', 'Cast iron', ];
        $a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $arr_categories = Category::all()->toArray();

        for ($i=0; $i<24; $i++) {

            $manufacturer = $arrManuf[rand(0, count($arrManuf)-1)];
            // $type = $arrType[rand(0, count($arrType)-1)];
            $category = $arr_categories[ rand(1, count($arr_categories)-1) ]; // no parent category with id == 1
            $name = $manufacturer
                . ' '
                .  ucwords($category['name'])
                . ' Guitar ' 
                . $a[rand(0, strlen($a)-1)] 
                . $a[rand(0, strlen($a)-1)] 
                . '-' 
                . rand(5, 215);
            $materials = $arrMaterial[rand(0, count($arrMaterial)-1)];


            DB::table('products')->insert([
                'name' => $name,
                'manufacturer' => $manufacturer,
                'show' => rand(0, 5) ? 1 : 0,
                'category_id' => $category['id'],
                'materials' => $materials,
                'description' => 'lorem ipsum, quia dolor sit amet consectetur adipiscing velit, sed quia non-numquam do eius modi tempora incididunt, ut labore et dolore magnam aliquam quaerat voluptatem.',
                'year_manufacture' => '2018',
                'price' => rand(20000,32000),
                'added_by_user_id' => 1,
            ]);
        }

    }
}
