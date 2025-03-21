@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
<div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
    @include('business::print.header')
    <h4 class="mt-2">{{ __('Product List') }}</h4>
</div>
@endsection

@section('pdf_content')
    <table class="styled-table">
        <thead>
            <tr>
                <th> {{ __('SL') }}. </th>
                <th> {{ __('Image') }} </th>
                <th> {{ __('Product Name') }} </th>
                <th> {{ __('Code') }} </th>
                <th> {{ __('Brand') }} </th>
                <th> {{ __('Category') }} </th>
                <th> {{ __('Unit') }} </th>
                <th> {{ __('Purchase price') }}</th>
                <th> {{ __('Sale price') }}</th>
                <th> {{ __('Stock') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td><img src="{{ asset($product->productPicture ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="table-product-img"></td>
                    <td>{{ $product->productName }}</td>
                    <td>{{ $product->productCode }}</td>
                    <td>{{ $product->brand->brandName ?? '' }}</td>
                    <td>{{ $product->category->categoryName ?? '' }}</td>
                    <td>{{ $product->unit->unitName ?? '' }}</td>
                    <td>{{ currency_format($product->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
                    <td>{{ currency_format($product->productSalePrice, 'icon', 2, business_currency()) }}</td>
                    <td>{{ $product->productStock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
