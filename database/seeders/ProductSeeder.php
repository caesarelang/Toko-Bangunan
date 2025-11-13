<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Buat kategori
        $categories = [
            'Semen',
            'Cat Tembok',
            'Besi & Baja',
            'Kayu & Triplek',
            'Keramik',
            'Pipa & Fitting',
        ];

        $categoryMap = [];
        foreach ($categories as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $categoryMap[$categoryName] = $category->id;
        }

        // Data produk dengan kategori fix
        $products = [
            [
                'category' => 'Semen',
                'name' => 'Semen Tiga Roda 50Kg',
                'price' => 75000,
                'stock' => 100,
            ],
            [
                'category' => 'Semen',
                'name' => 'Semen Gresik 40Kg',
                'price' => 68000,
                'stock' => 200,
            ],
            [
                'category' => 'Cat Tembok',
                'name' => 'Cat Dulux EasyClean 2.5L',
                'price' => 120000,
                'stock' => 40,
            ],
            [
                'category' => 'Cat Tembok',
                'name' => 'Cat Nippon Vinilex 5L',
                'price' => 135000,
                'stock' => 25,
            ],
            [
                'category' => 'Besi & Baja',
                'name' => 'Besi Beton 12mm',
                'price' => 95000,
                'stock' => 150,
            ],
            [
                'category' => 'Besi & Baja',
                'name' => 'Besi Hollow 2x4',
                'price' => 78000,
                'stock' => 120,
            ],
            [
                'category' => 'Kayu & Triplek',
                'name' => 'Triplek 12mm',
                'price' => 85000,
                'stock' => 80,
            ],
            [
                'category' => 'Keramik',
                'name' => 'Keramik Roman 40x40',
                'price' => 65000,
                'stock' => 200,
            ],
            [
                'category' => 'Keramik',
                'name' => 'Keramik Platinum 30x30',
                'price' => 55000,
                'stock' => 180,
            ],
            [
                'category' => 'Pipa & Fitting',
                'name' => 'Pipa PVC 1 Inch',
                'price' => 25000,
                'stock' => 300,
            ],
        ];

        // Masukkan produk
        foreach ($products as $data) {
            Product::updateOrCreate(
                ['name' => $data['name']],
                [
                    'category_id' => $categoryMap[$data['category']],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'description' => fake()->sentence(),
                    'image' => null,
                ]
            );
        }

        echo "✅ Product & Category seeding completed successfully!\n";
    }
}
