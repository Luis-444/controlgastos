@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="modal__header">
        {{ $title }}
    </div>

    <div class="modal__content">
        {{ $content }}
    </div>
    <div class="modal__footer">
        {{ $footer }}
    </div>
</x-modal>
