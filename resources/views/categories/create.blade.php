<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-3xl">
        <x-section-card title="Form Kategori" icon="tag">
            @include('categories._form', ['action' => route('categories.store')])
        </x-section-card>
    </div>
</x-app-layout>
