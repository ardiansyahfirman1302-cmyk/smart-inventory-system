<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-3xl">
        <x-section-card title="Edit Lokasi" icon="warehouse">
            @include('locations._form', [
                'location' => $location,
                'action' => route('locations.update', $location),
                'method' => 'PUT',
            ])
        </x-section-card>
    </div>
</x-app-layout>
