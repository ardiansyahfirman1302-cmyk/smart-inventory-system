<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-5xl">
        <x-section-card title="Edit Barang" icon="package">
            @include('products._form', [
                'product' => $product,
                'action' => route('products.update', $product),
                'method' => 'PUT',
                'categories' => $categories,
                'suppliers' => $suppliers,
                'locations' => $locations,
            ])
        </x-section-card>
    </div>
</x-app-layout>
