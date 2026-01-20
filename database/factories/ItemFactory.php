<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $items = [
            // Elektronik
            ['name' => 'Laptop ASUS ROG Zephyrus', 'category' => 'Elektronik', 'brand' => 'ASUS', 'unit' => 'Unit', 'price' => 25000000],
            ['name' => 'Laptop ASUS Vivobook', 'category' => 'Elektronik', 'brand' => 'ASUS', 'unit' => 'Unit', 'price' => 8500000],
            ['name' => 'Printer Epson L3210', 'category' => 'Elektronik', 'brand' => 'Epson', 'unit' => 'Unit', 'price' => 2100000],
            ['name' => 'Proyektor Epson EB-X500', 'category' => 'Elektronik', 'brand' => 'Epson', 'unit' => 'Unit', 'price' => 5500000],
            ['name' => 'Mouse Wireless Logitech M331', 'category' => 'Elektronik', 'brand' => 'Logitech', 'unit' => 'Pcs', 'price' => 150000],
            ['name' => 'Keyboard Mechanical Logitech K845', 'category' => 'Elektronik', 'brand' => 'Logitech', 'unit' => 'Pcs', 'price' => 890000],
            ['name' => 'Monitor Samsung 24 Inch', 'category' => 'Elektronik', 'brand' => 'Samsung', 'unit' => 'Unit', 'price' => 1800000],

            // Alat Tulis
            ['name' => 'Kertas HVS A4 70gr', 'category' => 'Alat Tulis', 'brand' => 'Sinar Dunia', 'unit' => 'Rim', 'price' => 45000],
            ['name' => 'Kertas HVS F4 70gr', 'category' => 'Alat Tulis', 'brand' => 'Sinar Dunia', 'unit' => 'Rim', 'price' => 50000],
            ['name' => 'Pulpen Faber-Castell 0.5mm', 'category' => 'Alat Tulis', 'brand' => 'Faber-Castell', 'unit' => 'Pcs', 'price' => 5000],
            ['name' => 'Pensil 2B Faber-Castell', 'category' => 'Alat Tulis', 'brand' => 'Faber-Castell', 'unit' => 'Pcs', 'price' => 3000],
            ['name' => 'Spidol Papan Tulis Hitam', 'category' => 'Alat Tulis', 'brand' => 'Snowman', 'unit' => 'Pcs', 'price' => 8000],
            ['name' => 'Penghapus Karet', 'category' => 'Alat Tulis', 'brand' => 'Faber-Castell', 'unit' => 'Pcs', 'price' => 2000],
            ['name' => 'Buku Tulis Sidu 58 Lembar', 'category' => 'Alat Tulis', 'brand' => 'Sinar Dunia', 'unit' => 'Pack', 'price' => 35000],

            // Perabotan
            ['name' => 'Kursi Kantor Ergonomis', 'category' => 'Perabotan', 'brand' => 'Informa', 'unit' => 'Unit', 'price' => 1200000],
            ['name' => 'Meja Kerja Minimalis', 'category' => 'Perabotan', 'brand' => 'Informa', 'unit' => 'Unit', 'price' => 1500000],
            ['name' => 'Lemari Arsip Besi', 'category' => 'Perabotan', 'brand' => 'Informa', 'unit' => 'Unit', 'price' => 2500000],
            ['name' => 'Rak Buku 5 Susun', 'category' => 'Perabotan', 'brand' => 'IKEA', 'unit' => 'Unit', 'price' => 850000],

            // Kebersihan
            ['name' => 'Tisu Wajah Paseo 250 Sheets', 'category' => 'Kebutuhan Habis Pakai', 'brand' => 'Paseo', 'unit' => 'Pack', 'price' => 12000],
            ['name' => 'Hand Sanitizer 500ml', 'category' => 'Kesehatan', 'brand' => 'Dettol', 'unit' => 'Botol', 'price' => 35000],
        ];

        $selectedItem = $this->faker->randomElement($items);

        $category = Category::firstOrCreate(['name' => $selectedItem['category']]);
        $brand = Brand::firstOrCreate(['name' => $selectedItem['brand']]);
        $unit = Unit::firstOrCreate(['name' => $selectedItem['unit']]);

        return [
            'name' => $selectedItem['name'],
            'image' => null, // Atau bisa gunakan fake()->imageUrl() jika ada koneksi
            'code' => strtoupper($this->faker->bothify('ITM-####-????')),
            'price' => $selectedItem['price'],
            'quantity' => $this->faker->numberBetween(1, 100),
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'unit_id' => $unit->id,
            'active' => 1,
            'condition' => $this->faker->randomElement(['Baik', 'Rusak Ringan', 'Perlu Perbaikan']),
            'tanggal_masuk' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
