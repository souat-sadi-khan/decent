<div class="">
    @foreach ($models as $item)
    @php
        $check = App\models\Production\Category::where('id', $item->category_id)->first();
    @endphp
        <span class="badge badge-info">{{$item->name}} - {{ $item->category_id != null ? $check->name : 'All Category'}} </span>
    @endforeach
</div>