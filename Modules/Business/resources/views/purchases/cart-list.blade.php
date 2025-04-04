@foreach($cart_contents as $cart)
    <tr data-row_id="{{ $cart->rowId }}" data-update_route="{{ route('business.carts.update', $cart->rowId) }}" data-destroy_route="{{ route('business.carts.destroy', $cart->rowId) }}">
        <td class='text-start '>
            <img class="table-img" src="{{ asset($cart->options->product_image ?? 'assets/images/products/box.svg') }}">
        </td>
        <td class='text-start'>{{ $cart->name }}</td>
        <td class='text-start'>{{ $cart->options->product_code }}</td>
        <td class='text-start'>{{ $cart->options->product_unit_name }}</td>
        <td class='text-center'>{{ currency_format($cart->price, 'icon', 2, business_currency()) }}</td>
        <td class='text-start'>
            <div class="d-flex align-items-center gap-3">
                <button class="incre-decre minus-btn">
                    <i class="fas fa-minus icon"></i>
                </button>
                <input type="number" value="{{ $cart->qty }}" class="custom-number-input cart-qty" placeholder="{{ __('0') }}">
                <button class="incre-decre plus-btn">
                    <i class="fas fa-plus icon"></i>
                </button>
            </div>
        </td>
        <td class="cart-subtotal">{{ currency_format($cart->subtotal, 'icon', 2, business_currency()) }}</td>
        <td>
            <button class='x-btn remove-btn'>
                <img src="{{ asset('assets/images/icons/x.svg') }}" alt="">
            </button>
        </td>
    </tr>
@endforeach
