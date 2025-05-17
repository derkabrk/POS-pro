@extends('business::layouts.blank')

@section('title')
    {{ __('Invoice') }}
@endsection

@section('main_content')
    <div id="barcodePrintArea" class="barcode-container ">
        <div class="row g-2 ">
            @foreach ($generatedBarcodes ?? [] as $barcode)
                <div class="col-3">
                    <div class="barcode-content">
                        @if ($barcode['show_product_name'])
                            <p class="title" style="font-size: {{ $barcode['product_name_size'] }}px;">
                                {{ $barcode['product_name'] }}
                            </p>
                        @endif
                        @if ($barcode['show_product_price'])
                            <p class="price" style="font-size: {{ $barcode['product_price_size'] }}px;">
                                Price: <span>{{ currency_format($barcode['product_price'], currency:business_currency()) }}</span>
                            </p>
                        @endif
                        @if ($barcode['show_pack_date'])
                            <p class="date" style="font-size: {{ $barcode['pack_date_size'] }}px;">
                                Packing Date: {{ $barcode['packing_date'] }}
                            </p>
                        @endif
                        <img src="data:image/png;base64,{{ base64_encode($barcode['barcode_svg']) }}" alt="Barcode Image">
                        @if ($barcode['show_product_code'])
                            <p class="number" style="font-size: {{ $barcode['product_code_size'] }}px;">
                                {{ $barcode['product_code'] }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<script>
    window.onload = function () {
        window.print();
    };
</script>
