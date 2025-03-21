// currency format
function currencyFormat(amount, type = "icon", decimals = 2) {
    let symbol = $('#currency_symbol').val();
    let position = $('#currency_position').val();
    let code = $('#currency_code').val();

    let formatted_amount = formattedAmount(amount, decimals);

    // Apply currency format based on the position and type
    if (type === "icon" || type === "symbol") {
        if (position === "right") {
            return formatted_amount + symbol;
        } else {
            return symbol + formatted_amount;
        }
    } else {
        if (position === "right") {
            return formatted_amount + ' ' + code;
        } else {
            return code + ' ' + formatted_amount;
        }
    }
}
// Format the amount
function formattedAmount(amount, decimals){
    return  Number.isInteger(+amount) ? parseInt(amount) : (+amount).toFixed(decimals);
}

// get number only
function getNumericValue(value) {
    return parseFloat(value.replace(/[^0-9.-]+/g, "")) || 0;
}

// Update the cart list and call the callback once complete
function fetchUpdatedCart(callback) {
    let url = $('#purchase-cart').val();
    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            $('#purchase_cart_list').html(response);
            if (typeof callback === "function") callback(); // Call the callback after updating the cart
        },
    });
}

//increase quantity
$(document).on('click', '.plus-btn', function(e) {
    e.preventDefault();
    let $row = $(this).closest('tr');
    let rowId = $row.data('row_id');
    let updateRoute = $row.data('update_route');
    let $qtyInput = $row.find('.cart-qty');
    let currentQty = parseInt($qtyInput.val());

    let newQty = currentQty + 1;
    $qtyInput.val(newQty);
    updateCartQuantity(rowId, newQty, updateRoute);
});

//decrease quantity
$(document).on('click', '.minus-btn', function(e) {
    e.preventDefault();
    let $row = $(this).closest('tr');
    let rowId = $row.data('row_id');
    let updateRoute = $row.data('update_route');
    let $qtyInput = $row.find('.cart-qty')
    let currentQty = parseInt($qtyInput.val());

    // Ensure quantity does not go below 1
    if (currentQty > 1) {
        let newQty = currentQty - 1;
        $qtyInput.val(newQty);
        updateCartQuantity(rowId, newQty, updateRoute);
    }
});

// Cart quantity input field change event
$(document).on('change', '.cart-qty', function() {
    let $row = $(this).closest('tr');
    let rowId = $row.data('row_id');
    let updateRoute = $row.data('update_route');
    let newQty = parseInt($(this).val());

    // Ensure quantity does not go below 1
    if (newQty >= 0) {
        updateCartQuantity(rowId, newQty, updateRoute);
    }
});

// Remove item from the cart
$(document).on('click', '.remove-btn', function(e) {
    e.preventDefault();
    var $row = $(this).closest('tr');
    var destroyRoute = $row.data('destroy_route');

    $.ajax({
        url: destroyRoute,
        type: 'DELETE',
        success: function(response) {
            if (response.success) {
                // Item was successfully removed, fade out and remove the row from DOM
                $row.fadeOut(400, function() {
                    $(this).remove();
                });
                // Recalculate and update cart totals
                fetchUpdatedCart(calTotalAmount);
            } else {
                toastr.error(response.message || 'Failed to remove item');
            }
        },
        error: function() {
            toastr.error('Error removing item from cart');
        }
    });
});

// Function to update cart item with the new quantity
function updateCartQuantity(rowId, newQty, updateRoute) {
    $.ajax({
        url: updateRoute,
        type: 'PUT',
        data: {
            rowId: rowId,
            qty: newQty,
        },
        success: function(response) {
            if (response.success) {
                fetchUpdatedCart(calTotalAmount); // Re-fetch the cart and recalculate the total amount
            } else {
                toastr.error(response.message || 'Failed to update quantity');
            }
        },
        error: function() {
            toastr.error('Error updating cart quantity');
        }
    });
}

// Clear the cart and then refresh the UI with updated values
function clearCart(cartType) {
    let route = $('#clear-cart').val();
    $.ajax({
        type: 'POST',
        url: route,
        data: {
            type: cartType
        },
        dataType: "json",
        success: function (response) {
            fetchUpdatedCart(calTotalAmount); // Call calTotalAmount after cart fetch completes
        },
        error: function () {
            console.error("There was an issue clearing the cart.");
        }
    });
}

/** Add to cart start **/

let selectedProduct = {};

$(document).on('click', '#single-product', function () {
    showProductModal($(this));
});

function autoOpenModal(id) {
    let element = $('#products-list').find('.single-product.' + id);
    showProductModal(element);
};

function showProductModal(element) {
    selectedProduct = {};

    selectedProduct = {
        product_id: element.data('product_id'),
        product_code: element.data('product_code'),
        product_unit_id: element.data('product_unit_id'),
        product_unit_name: element.data('product_unit_name'),
        product_image: element.data('product_image'),
        product_name: element.find('.product_name').text(),
        brand: element.data('brand'),
        stock: element.data('stock'),
        purchase_price: element.data('purchase_price'),
        sales_price: element.data('sales_price'),
        whole_sale_price: element.data('whole_sale_price'),
        dealer_price: element.data('dealer_price')
    };

    // Set modal display values
    $('#product_name').text(selectedProduct.product_name);
    $('#brand').text(selectedProduct.brand);
    $('#stock').text(selectedProduct.stock);
    $('#purchase_price').val(selectedProduct.purchase_price);
    $('#sales_price').val(selectedProduct.sales_price);
    $('#whole_sale_price').val(selectedProduct.whole_sale_price);
    $('#dealer_price').val(selectedProduct.dealer_price);

    $('#product-modal').modal('show');
}

$('.product-filter').on('submit', function(e) {
    e.preventDefault();
});

let savingLoader =
        '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
    $purchase_modal_reload = $("#purchase_modal");
$purchase_modal_reload.initFormValidation(),

// item modal action
$('#purchase_modal').on('submit', function (e) {
    e.preventDefault();
    let t = $(this).find(".submit-btn"),
        a = t.html();
    let url = $(this).data('route');
    let quantity = parseInt($('#product_qty').val());
    $purchase_modal_reload.valid() &&
        $.ajax({
        url: url,
        type: 'POST',
        data: {
            type: 'purchase',
            id: selectedProduct.product_id,
            name: selectedProduct.product_name,
            quantity: quantity,
            price: parseFloat($('#purchase_price').val()),
            sales_price: parseFloat($('#sales_price').val()),
            whole_sale_price: parseFloat($('#whole_sale_price').val()),
            dealer_price: parseFloat($('#dealer_price').val()),
            product_code: selectedProduct.product_code,
            product_unit_id: selectedProduct.product_unit_id,
            product_unit_name: selectedProduct.product_unit_name,
            product_image: selectedProduct.product_image,
        },
            beforeSend: function () {
                t.html(savingLoader).attr("disabled", !0);
            },
        success: function (response) {
            t.html(a).removeClass("disabled").attr("disabled", !1);

            if (response.success) {
                fetchUpdatedCart(calTotalAmount); // Update totals after cart fetch completes
                $('#product-modal').modal('hide');
                $('#product_qty').val('');
            } else {
                toastr.error(response.message || 'Failed to add product to cart.');
            }
        },
        error: function (xhr) {
            toastr.error('An error occurred while adding product to cart.');
        }
    });
});

/** Add to cart End **/

// Trigger calculation whenever Discount, or Receive Amount fields change
$('#discount_amount, #receive_amount, #shipping_charge').on('input', function () {
    calTotalAmount();
});

// vat calculation
$('.vat_select').on('change', function () {
    let vatRate = parseFloat($(this).find(':selected').data('rate')) || 0;
    let subtotal = getNumericValue($('#sub_total').text()) || 0;

    let vatAmount = (subtotal * vatRate) / 100;

    $('#vat_amount').val(vatAmount.toFixed(2));
    calTotalAmount();
});

// discount calculation
$('.discount_type').on('change', function () {
    calTotalAmount();
});

// Function to calculate the total amount
function calTotalAmount() {
    let subtotal = 0;

    // Calculate subtotal from cart list
    $('#purchase_cart_list tr').each(function () {
        let cart_subtotal = getNumericValue($(this).find('.cart-subtotal').text()) || 0;
        subtotal += cart_subtotal;
    });

    $('#sub_total').text(currencyFormat(subtotal));

    // Vat
    let vat_rate = parseFloat($('.vat_select option:selected').data('rate')) || 0;
    let vat_amount = (subtotal * vat_rate) / 100;
    $('#vat_amount').val(vat_amount.toFixed(2));

    // Discount
    let discount_amount = getNumericValue($('#discount_amount').val()) || 0;
    let discount_type = $('.discount_type').val(); // Get the selected discount type

    if (discount_type == 'percent') {
        discount_amount = (subtotal * discount_amount) / 100;

        // Ensure percentage discount does not exceed 100%
        if (discount_amount > subtotal) {
            toastr.error('Discount cannot be more than 100% of the subtotal!');
            discount_amount = subtotal; // Cap discount at subtotal
            $('#discount_amount').val(100); // Reset input field to max 100%
        }
    } else {
        if (discount_amount > subtotal) {
            toastr.error('Discount cannot be more than the subtotal!');
            discount_amount = subtotal;
            $('#discount_amount').val(discount_amount);
        }
    }

    //Shipping Charge
    let shipping_charge = getNumericValue($('#shipping_charge').val()) || 0;

    // Total Amount
    let total_amount = subtotal + vat_amount + shipping_charge - discount_amount;
    $('#total_amount').text(currencyFormat(total_amount));

    // Receive Amount
    let receive_amount = getNumericValue($('#receive_amount').val()) || 0;
    if (receive_amount < 0) {
        toastr.error('Receive amount cannot be less than 0!');
        receive_amount = 0;
        $('#receive_amount').val(receive_amount);
    }

    // Change Amount
    let change_amount = receive_amount > total_amount ? receive_amount - total_amount : 0;
    $('#change_amount').val(change_amount.toFixed(2)); // Numeric value only

    // Due Amount
    let due_amount = total_amount > receive_amount ? total_amount - receive_amount : 0;
    $('#due_amount').val(due_amount.toFixed(2)); // Numeric value only
}
calTotalAmount();

// Cancel btn action
$('.cancel-sale-btn').on('click', function (e) {
    e.preventDefault();
    clearCart('purchase');
});

// Sidebar compress style
$('.side-bar, .section-container').toggleClass('active', window.innerWidth >= 1150);

$('.product-filter').on('input', '.search-input', function (e) {
    fetchProducts();
});

function fetchProducts() {
    var form = $('form.product-filter')[0];

    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: new FormData(form),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            $('#products-list').html(res.data);
            if (res.total_products && res.product_id) {
                autoOpenModal(res.product_id);
                $('#purchase_product_search').val('');
                fetchProducts();
            }
        }
    });
}

$(document).on('click', '.category-content', function () {
    let url = $('#category-filter').val();
    const categoryId = $(this).data('id');
    $.ajax({
        type: "POST",
        url: url,
        data: { category_id: categoryId },
        success: function (response) {
            $('.product-list-container').html(response.data);
        }
    });
});


$(document).on('click', '.brand-search', function () {
    let url = $('#brand-filter').val();
    const brandId = $(this).data('id');

    $.ajax({
        type: "POST",
        url: url,
        data: { brand_id: brandId },
        success: function (response) {
            $('.product-list-container').html(response.data);
        }
    });
});

// Category Filter
$('.category-search').on('input', function (e) {
    e.preventDefault();
    // Get search query
    const search = $(this).val();
    const route = $(this).closest('form').data('route');

    $.ajax({
        type: "POST",
        url: route,
        data: {
            search: search,
        },
        success: function (response) {
            $('#category-data').html(response.categories);
        },
    });
});

// brand Filter
$('.brand-search').on('input', function(e) {
    e.preventDefault();

    // Get search query
    const search = $(this).val();

    const route = $(this).closest('form').data('route');

    $.ajax({
        type: "POST",
        url: route,
        data: {
            search: search,
        },
        success: function(response) {
            $('#brand-data').html(response.brands);
        },
    });
});

// When select brand or product
$(document).on('click', '.category-list, .brand-list', function () {
    const isCategory = $(this).hasClass('category-list');
    const filterType = isCategory ? 'category_id' : 'brand_id';
    const filterId = $(this).data('id');
    const route = $(this).data('route'); // product filter route

    const searchTerm = $('#purchase_product_search').val();

    $.ajax({
        type: "POST",
        url: route,
        data: {
            search: searchTerm,
            [filterType]: filterId, // Dynamically set category_id or brand_id
        },
        success: function (response) {
            $('#products-list').html(response.data);
            $('#category-list').html(response.categories);
            $('#brand-list').html(response.brands);
        },
    });
});
