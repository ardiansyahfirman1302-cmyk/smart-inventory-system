<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-4xl">
        <x-section-card title="Form Barang Keluar" subtitle="Stok akan otomatis berkurang setelah tersimpan" icon="arrow-up-from-line">
            @include('stock-outs._form', ['action' => route('stock-outs.store'), 'products' => $products])
        </x-section-card>
    </div>
</x-app-layout>
