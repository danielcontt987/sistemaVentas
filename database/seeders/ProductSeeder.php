<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::create([
            'name' => 'Crema LALA',
            'cost' => 18.00,
            'price' => 25.00,
            'barcode' => '7584691234',
            'stock' => 100,
            'alerts' => 5,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'GALLETAS CHOKIES',
            'cost' => 12.00,
            'price' => 25.00,
            'barcode' => '7584691297',
            'stock' => 100,
            'alerts' => 5,
            'category_id' => 4,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'PAPAS FLAMING HOT',
            'cost' => 18.00,
            'price' => 20.00,
            'barcode' => '7584691420',
            'stock' => 100,
            'alerts' => 10,
            'category_id' => 3,
            'image' => 'curso.png'
        ]);
        Product::create([
            'name' => 'QUESO OAXACA',
            'cost' => 18.00,
            'price' => 25.00,
            'barcode' => '7584691576',
            'stock' => 100,
            'alerts' => 5,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);

    }
}
