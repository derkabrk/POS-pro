<?php

namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'sale');
        return view('business::sales.cart-list', compact('cart_contents'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'nullable|string|in:sale,purchase',
            'id' => 'required|integer',
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'product_code' => 'nullable|string',
            'product_unit_id' => 'nullable|integer',
            'product_unit_name' => 'nullable|string',
            'product_image' => 'nullable|string',
            'sales_price' => 'nullable|numeric',
            'whole_sale_price' => 'nullable|numeric',
            'dealer_price' => 'nullable|numeric',
        ]);

        // Search for existing item in the cart
        $existingCartItem = Cart::search(function ($cartItem) use ($request) {
            return $cartItem->id == $request->id && $cartItem->options->type == $request->type;
        })->first();

        if ($existingCartItem) {
            // Update the quantity of the existing item
            $newQuantity = $existingCartItem->qty + $request->quantity;
            Cart::update($existingCartItem->rowId, [
                'qty' => $newQuantity,
            ]);
        } else {
            // Add new item to the cart
            $mainItemData = [
                'id' => $request->id,
                'name' => $request->name,
                'qty' => $request->quantity,
                'price' => $request->price, // sale or purchase price
                'options' => [
                    'type' => $request->type,
                    'product_code' => $request->product_code,
                    'product_unit_id' => $request->product_unit_id,
                    'product_unit_name' => $request->product_unit_name,
                    'product_image' => $request->product_image,
                ]
            ];
            // Conditionally add fields if type is 'sale'
            if ($request->type == 'purchase') {
                $mainItemData['options']['sales_price'] = $request->sales_price;
                $mainItemData['options']['whole_sale_price'] = $request->whole_sale_price;
                $mainItemData['options']['dealer_price'] = $request->dealer_price;
            }

            Cart::add($mainItemData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully!'
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $cart = Cart::get($id);

            if ($cart) {
                $quantity = $request->input('qty');
                $price = $request->input('price'); // If sale

                if ($quantity >= 0) {
                    $updateData = ['qty' => $quantity];

                    if ($price !== null && $price >= 0) {
                        $updateData['price'] = $price;
                    }

                    // Update the cart
                    Cart::update($id, $updateData);

                    return response()->json([
                        'success' => true,
                        'message' => __('Quantity') .
                            ($price !== null ? __(' and price') : '') .
                            __(' updated successfully')
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => __('Enter a valid quantity')]);
                }
            } else {
                return response()->json(['success' => false, 'message' => __('Item not found in the cart')]);
            }
        } catch (InvalidRowIDException $e) {
            return response()->json(['success' => false, 'message' => __('The cart does not contain this item')]);
        }
    }

    public function destroy($id)
    {
        try {
            Cart::remove($id);
            return response()->json(['success' => true, 'message' => __('Item removed from cart')]);
        } catch (InvalidRowIDException $e) {
            return response()->json(['success' => false, 'message' => __('The cart does not contain this item')]);
        }
    }

    public function removeAllCart(Request $request)
    {
        $carts = Cart::content();

        if ($carts->count() < 1) {
            return response()->json(['message' => __('Cart is empty. Add items first!')]);
        }

        Cart::destroy();

        $response = [
            'success' => true,
            'message' => __('All cart removed successfully!'),
        ];

        return response()->json($response);
    }
}
