<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-4xl">
        <x-section-card title="Edit Barang Masuk" subtitle="Perubahan qty akan menyesuaikan stok otomatis" icon="arrow-down-to-line">
            @include('stock-ins._form', [
                'stockIn' => $stockIn,
                'action' => route('stock-ins.update', $stockIn),
                'method' => 'PUT',
                'products' => $products,
                'suppliers' => $suppliers,
            ])
        </x-section-card>
    </div>
</x-app-layout>
