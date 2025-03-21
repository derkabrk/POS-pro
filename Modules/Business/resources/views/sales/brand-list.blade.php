@foreach ($brands as $brand)
    <div class="category-content brand-list"
         data-id="{{ $brand->id }}"
         data-route="{{ route('business.sales.product-filter') }}">
        <img class="category-brand-img " src="{{ asset($brand->icon ?? '') }}" alt="">
        <h6 class="brand-name">{{ $brand->brandName }}</h6>
    </div>
@endforeach
