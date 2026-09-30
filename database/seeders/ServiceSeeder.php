<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Wash Only',
                'service_name' => 'Wash Only',
                'service_type' => 'Wash Only',
                'price' => 1.50,
                'price_per_kg' => 1.50,
                'price_per_item' => null,
                'estimated_time' => '1–2 days',
                'estimated_completion_hrs' => 24,
                'description' => 'Standard machine washing cycle using high-grade eco detergents.',
                'status' => 'Active',
            ],
            [
                'name' => 'Wash & Dry',
                'service_name' => 'Wash & Dry',
                'service_type' => 'Wash & Dry',
                'price' => 2.50,
                'price_per_kg' => 2.50,
                'price_per_item' => null,
                'estimated_time' => '2–3 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Machine washing and full tumble drying with gentle fabric softener.',
                'status' => 'Active',
            ],
            [
                'name' => 'Wash, Dry & Fold',
                'service_name' => 'Wash, Dry & Fold',
                'service_type' => 'Wash, Dry & Fold',
                'price' => 3.50,
                'price_per_kg' => 3.50,
                'price_per_item' => null,
                'estimated_time' => '2–3 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Complete laundry service: washed, tumble dried, and neatly crisply folded.',
                'status' => 'Active',
            ],
            [
                'name' => 'Dry Cleaning',
                'service_name' => 'Dry Cleaning',
                'service_type' => 'Dry Cleaning',
                'price' => 4.00,
                'price_per_kg' => 4.00,
                'price_per_item' => null,
                'estimated_time' => '3–5 days',
                'estimated_completion_hrs' => 72,
                'description' => 'Eco-solvent dry cleaning for delicate fabrics, suits, blazers, and dresses.',
                'status' => 'Active',
            ],
            [
                'name' => 'Ironing',
                'service_name' => 'Ironing',
                'service_type' => 'Ironing',
                'price' => 2.00,
                'price_per_kg' => 2.00,
                'price_per_item' => null,
                'estimated_time' => '1–2 days',
                'estimated_completion_hrs' => 24,
                'description' => 'Steam pressing and wrinkle-free ironing delivered on sturdy hangers.',
                'status' => 'Active',
            ],
            [
                'name' => 'Blanket Cleaning',
                'service_name' => 'Blanket Cleaning',
                'service_type' => 'Blanket Cleaning',
                'price' => 2.80,
                'price_per_kg' => 2.80,
                'price_per_item' => null,
                'estimated_time' => '2–4 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Deep sanitization and washing for heavy blankets, comforters, and duvets.',
                'status' => 'Active',
            ],
            [
                'name' => 'Curtain Cleaning',
                'service_name' => 'Curtain Cleaning',
                'service_type' => 'Curtain Cleaning',
                'price' => 3.00,
                'price_per_kg' => 3.00,
                'price_per_item' => null,
                'estimated_time' => '3–5 days',
                'estimated_completion_hrs' => 72,
                'description' => 'Professional dust removal, gentle steam wash and care for all curtain fabrics.',
                'status' => 'Active',
            ],
            [
                'name' => 'Shoe Cleaning',
                'service_name' => 'Shoe Cleaning',
                'service_type' => 'Shoe Cleaning',
                'price' => 4.50,
                'price_per_kg' => 4.50,
                'price_per_item' => null,
                'estimated_time' => '2–4 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Meticulous deep scrubbing, stain extraction, and polishing for sneakers and shoes.',
                'status' => 'Active',
            ],
            [
                'name' => 'Carpet Cleaning',
                'service_name' => 'Carpet Cleaning',
                'service_type' => 'Carpet Cleaning',
                'price' => 2.00,
                'price_per_kg' => 2.00,
                'price_per_item' => null,
                'estimated_time' => '2–4 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Deep rug and carpet extraction shampooing, odor neutralization and sanitization.',
                'status' => 'Active',
            ],
        ];

        try {
            if (Schema::hasTable('services')) {
                foreach ($services as $data) {
                    Service::updateOrCreate(
                        ['name' => $data['name']],
                        $data
                    );
                }
            }
        } catch (\Throwable $e) {
            // In case DB is not reachable
        }
    }
}
