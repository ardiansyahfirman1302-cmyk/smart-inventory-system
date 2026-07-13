<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-5xl">
        <x-section-card title="Form Barang" icon="package">
            @include('products._form', [
                'action' => route('products.store'),
                'categories' => $categories,
                'suppliers' => $suppliers,
                'locations' => $locations,
            ])
        </x-section-card>
    </div>
</x-app-layout>
