<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-4xl">
        <x-section-card title="Form Barang Masuk" subtitle="Stok akan otomatis bertambah setelah tersimpan" icon="arrow-down-to-line">
            @include('stock-ins._form', ['action' => route('stock-ins.store'), 'products' => $products, 'suppliers' => $suppliers])
        </x-section-card>
    </div>
</x-app-layout>
