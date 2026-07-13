<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-4xl">
        <x-section-card title="Edit Tiket" icon="wrench">
            @include('maintenances._form', [
                'maintenance' => $maintenance,
                'action' => route('maintenances.update', $maintenance),
                'method' => 'PUT',
                'products' => $products,
            ])
        </x-section-card>
    </div>
</x-app-layout>
