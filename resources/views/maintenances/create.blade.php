<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-4xl">
        <x-section-card title="Form Tiket Maintenance" icon="wrench">
            @include('maintenances._form', ['action' => route('maintenances.store'), 'products' => $products])
        </x-section-card>
    </div>
</x-app-layout>
