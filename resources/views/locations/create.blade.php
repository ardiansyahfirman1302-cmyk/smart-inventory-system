<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-3xl">
        <x-section-card title="Form Lokasi" icon="warehouse">
            @include('locations._form', ['action' => route('locations.store')])
        </x-section-card>
    </div>
</x-app-layout>
