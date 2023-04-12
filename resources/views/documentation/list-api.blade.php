@foreach ($listapipublish as $item)
    <div class="hover-list-api button-result-document px-3 my-3" data-id="{{ $item->id }}">
        <p class="documentation-list-api mx-auto my-auto py-2">{{ $item->name }}</p>
    </div>
@endforeach