@foreach($cart_contents as $cart)
    <tr data-row_id="{{ $cart->rowId }}" data-update_route="{{ route('business.carts.update', $cart->rowId) }}" data-destroy_route="{{ route('business.carts.destroy', $cart->rowId) }}">
        <td >
            <img class="table-img" src="{{ asset($cart->options->product_image ?? 'assets/images/products/box.svg') }}">
        </td>
        <td >{{ $cart->name }}</td>
        <td >{{ $cart->options->product_code }}</td>
        <td >{{ $cart->options->product_unit_name }}</td>

        <td >
            <input class="text-center sales-input cart-price" type="number" step="any" min="0" value="{{ $cart->price }}" placeholder="0">
        </td>

        <td class="large-td">
            <div class="d-flex  align-items-center" >
                <button class="incre-decre minus-btn">
                    <i class="fas fa-minus icon"></i>
                </button>
                <input type="number" value="{{ $cart->qty }}" class="custom-number-input cart-qty" placeholder="{{ __('0') }}" >
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
