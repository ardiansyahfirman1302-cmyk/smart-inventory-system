<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-3xl">
        <x-section-card title="Form Supplier" icon="building-2">
            @include('suppliers._form', ['action' => route('suppliers.store')])
        </x-section-card>
    </div>
</x-app-layout>
