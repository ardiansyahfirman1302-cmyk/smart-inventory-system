<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <div class="max-w-3xl">
        <x-section-card title="Form Edit Kategori" icon="tag">
            @include('categories._form', [
                'category' => $category,
                'action' => route('categories.update', $category),
                'method' => 'PUT',
            ])
        </x-section-card>
    </div>
</x-app-layout>
