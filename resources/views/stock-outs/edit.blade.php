<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-4xl">
        <x-section-card title="Edit Barang Keluar" icon="arrow-up-from-line">
            @include('stock-outs._form', [
                'stockOut' => $stockOut,
                'action' => route('stock-outs.update', $stockOut),
                'method' => 'PUT',
                'products' => $products,
            ])
        </x-section-card>
    </div>
</x-app-layout>
