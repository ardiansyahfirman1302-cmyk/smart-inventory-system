<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Maintenance;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            ['code' => 'CAT-ELC', 'name' => 'Elektronik', 'description' => 'Perangkat elektronik & aksesorisnya'],
            ['code' => 'CAT-OFF', 'name' => 'Alat Kantor', 'description' => 'Perlengkapan kantor harian'],
            ['code' => 'CAT-FRN', 'name' => 'Furniture', 'description' => 'Meja, kursi, lemari'],
            ['code' => 'CAT-CON', 'name' => 'Consumables', 'description' => 'Barang habis pakai'],
            ['code' => 'CAT-TOL', 'name' => 'Tools', 'description' => 'Peralatan teknis'],
        ])->map(fn ($data) => Category::updateOrCreate(['code' => $data['code']], $data));

        $suppliers = collect([
            ['code' => 'SUP-001', 'name' => 'PT Sumber Makmur', 'contact_person' => 'Budi Santoso', 'phone' => '0812-3456-7890', 'email' => 'budi@sumbermakmur.co.id', 'address' => 'Jl. Merdeka No. 12, Jakarta'],
            ['code' => 'SUP-002', 'name' => 'CV Anugerah Sejahtera', 'contact_person' => 'Sari Wijaya', 'phone' => '0813-9876-5432', 'email' => 'sari@anugerah.co.id', 'address' => 'Jl. Diponegoro No. 45, Bandung'],
            ['code' => 'SUP-003', 'name' => 'PT Global Elektronik', 'contact_person' => 'Ahmad Rizki', 'phone' => '0821-1122-3344', 'email' => 'ahmad@globalelektronik.com', 'address' => 'Jl. Sudirman No. 88, Surabaya'],
            ['code' => 'SUP-004', 'name' => 'UD Berkah Jaya', 'contact_person' => 'Dewi Lestari', 'phone' => '0822-5566-7788', 'email' => 'dewi@berkahjaya.co.id', 'address' => 'Jl. Gatot Subroto No. 7, Semarang'],
        ])->map(fn ($data) => Supplier::updateOrCreate(['code' => $data['code']], $data));

        $locations = collect([
            ['code' => 'GDG-A', 'name' => 'Gudang A - Pusat', 'address' => 'Lantai 1, Blok A', 'pic_name' => 'Rudi Hartono'],
            ['code' => 'GDG-B', 'name' => 'Gudang B - Cabang', 'address' => 'Lantai 2, Blok B', 'pic_name' => 'Sinta Rahayu'],
            ['code' => 'GDG-C', 'name' => 'Gudang C - Arsip', 'address' => 'Basement, Blok C', 'pic_name' => 'Doni Prasetyo'],
        ])->map(fn ($data) => Location::updateOrCreate(['code' => $data['code']], $data));

        $productDefinitions = [
            ['sku' => 'PRD-0001', 'name' => 'Laptop Lenovo ThinkPad X1', 'category' => 'CAT-ELC', 'unit' => 'unit', 'price' => 18500000, 'stock' => 12, 'min_stock' => 5],
            ['sku' => 'PRD-0002', 'name' => 'Monitor LG 24 inch', 'category' => 'CAT-ELC', 'unit' => 'unit', 'price' => 2450000, 'stock' => 3, 'min_stock' => 5],
            ['sku' => 'PRD-0003', 'name' => 'Mouse Wireless Logitech M185', 'category' => 'CAT-ELC', 'unit' => 'pcs', 'price' => 165000, 'stock' => 0, 'min_stock' => 10],
            ['sku' => 'PRD-0004', 'name' => 'Keyboard Mechanical Rexus', 'category' => 'CAT-ELC', 'unit' => 'pcs', 'price' => 425000, 'stock' => 8, 'min_stock' => 4],
            ['sku' => 'PRD-0005', 'name' => 'Kertas A4 80gsm 500lbr', 'category' => 'CAT-OFF', 'unit' => 'rim', 'price' => 58000, 'stock' => 45, 'min_stock' => 20],
            ['sku' => 'PRD-0006', 'name' => 'Pulpen Standard AE7 (12pcs)', 'category' => 'CAT-OFF', 'unit' => 'pack', 'price' => 24000, 'stock' => 2, 'min_stock' => 10],
            ['sku' => 'PRD-0007', 'name' => 'Kursi Kantor Ergonomis', 'category' => 'CAT-FRN', 'unit' => 'unit', 'price' => 1850000, 'stock' => 6, 'min_stock' => 3],
            ['sku' => 'PRD-0008', 'name' => 'Meja Kerja Kayu 120cm', 'category' => 'CAT-FRN', 'unit' => 'unit', 'price' => 2100000, 'stock' => 4, 'min_stock' => 2],
            ['sku' => 'PRD-0009', 'name' => 'Tinta Printer Epson 003 Hitam', 'category' => 'CAT-CON', 'unit' => 'btl', 'price' => 95000, 'stock' => 0, 'min_stock' => 8],
            ['sku' => 'PRD-0010', 'name' => 'Tinta Printer Epson 003 Warna', 'category' => 'CAT-CON', 'unit' => 'btl', 'price' => 105000, 'stock' => 15, 'min_stock' => 8],
            ['sku' => 'PRD-0011', 'name' => 'Obeng Set Krisbow 32 pcs', 'category' => 'CAT-TOL', 'unit' => 'set', 'price' => 385000, 'stock' => 9, 'min_stock' => 3],
            ['sku' => 'PRD-0012', 'name' => 'Kabel LAN Cat6 10 meter', 'category' => 'CAT-ELC', 'unit' => 'roll', 'price' => 145000, 'stock' => 22, 'min_stock' => 10],
        ];

        $products = collect($productDefinitions)->map(function ($data) use ($categories, $suppliers, $locations) {
            $category = $categories->firstWhere('code', $data['category']);
            $supplier = $suppliers->random();
            $location = $locations->random();
            return Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'name' => $data['name'],
                    'category_id' => $category->id,
                    'supplier_id' => $supplier->id,
                    'location_id' => $location->id,
                    'unit' => $data['unit'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'min_stock' => $data['min_stock'],
                    'description' => $data['name'] . ' berkualitas tinggi.',
                ]
            );
        });

        $adminUser = User::where('email', 'admin@demo.com')->first();
        $staffUser = User::where('email', 'staff@demo.com')->first();
        $managerUser = User::where('email', 'manager@demo.com')->first();
        $actor = $adminUser ?? User::first();

        // Stock In - 25 transactions across last 6 months
        StockIn::query()->delete();
        for ($i = 0; $i < 25; $i++) {
            $product = $products->random();
            $qty = rand(5, 30);
            $unitPrice = (float) $product->price;
            $date = Carbon::now()->subDays(rand(0, 180));
            StockIn::create([
                'reference_no' => 'IN-' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'supplier_id' => $product->supplier_id,
                'user_id' => collect([$adminUser, $staffUser, $managerUser])->filter()->random()->id,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'total_price' => $qty * $unitPrice,
                'transaction_date' => $date,
                'notes' => 'Pembelian rutin bulanan.',
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // A few stock-in today to show "Barang Masuk Hari Ini"
        for ($i = 0; $i < 2; $i++) {
            $product = $products->random();
            $qty = rand(3, 10);
            StockIn::create([
                'reference_no' => 'IN-T' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'supplier_id' => $product->supplier_id,
                'user_id' => $actor->id,
                'quantity' => $qty,
                'unit_price' => (float) $product->price,
                'total_price' => $qty * (float) $product->price,
                'transaction_date' => Carbon::today(),
                'notes' => 'Pengadaan hari ini.',
            ]);
        }

        // Stock Out - 20 transactions across last 6 months
        StockOut::query()->delete();
        $purposes = ['Kebutuhan Divisi IT', 'Kebutuhan Marketing', 'Distribusi Cabang', 'Event Internal', 'Kebutuhan Operasional'];
        for ($i = 0; $i < 20; $i++) {
            $product = $products->random();
            $qty = rand(1, 8);
            $date = Carbon::now()->subDays(rand(0, 180));
            StockOut::create([
                'reference_no' => 'OUT-' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'user_id' => collect([$adminUser, $staffUser, $managerUser])->filter()->random()->id,
                'quantity' => $qty,
                'recipient' => fake()->name(),
                'purpose' => $purposes[array_rand($purposes)],
                'transaction_date' => $date,
                'notes' => 'Pengambilan barang.',
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // Stock out today
        for ($i = 0; $i < 3; $i++) {
            $product = $products->random();
            $qty = rand(1, 5);
            StockOut::create([
                'reference_no' => 'OUT-T' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'user_id' => $actor->id,
                'quantity' => $qty,
                'recipient' => fake()->name(),
                'purpose' => $purposes[array_rand($purposes)],
                'transaction_date' => Carbon::today(),
                'notes' => 'Pengambilan hari ini.',
            ]);
        }

        // Maintenance
        Maintenance::query()->delete();
        $statuses = ['pending', 'in_progress', 'completed', 'pending', 'in_progress'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        for ($i = 0; $i < 8; $i++) {
            $product = $products->random();
            $status = $statuses[array_rand($statuses)];
            Maintenance::create([
                'ticket_no' => 'MNT-' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'user_id' => $actor->id,
                'title' => 'Servis rutin ' . $product->name,
                'description' => 'Pemeriksaan berkala dan pembersihan komponen.',
                'status' => $status,
                'priority' => $priorities[array_rand($priorities)],
                'cost' => rand(50000, 500000),
                'scheduled_at' => Carbon::now()->addDays(rand(-10, 20)),
                'completed_at' => $status === 'completed' ? Carbon::now()->subDays(rand(0, 5)) : null,
            ]);
        }
    }
}
