<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-3xl">
        <x-section-card title="Edit Supplier" icon="building-2">
            @include('suppliers._form', [
                'supplier' => $supplier,
                'action' => route('suppliers.update', $supplier),
                'method' => 'PUT',
            ])
        </x-section-card>
    </div>
</x-app-layout>
