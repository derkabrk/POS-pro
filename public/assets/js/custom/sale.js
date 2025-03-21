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
    let url = $('#get-cart').val();
    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            $('#cart-list').html(response);
            if (typeof callback === "function") callback(); // Call the callback after updating the cart
        },
    });
}

// Update price
$(document).on('change', '.cart-price', function () {
    let $row = $(this).closest('tr');
    let rowId = $row.data('row_id');
    let updateRoute = $row.data('update_route');
    let newPrice = parseFloat($(this).val());

    if (newPrice < 0 || isNaN(newPrice)) {
        toastr.error('Price can not be negative.');
        return;
    }

    let currentQty = parseInt($row.find('.cart-qty').val());
    updateCart(rowId, currentQty, updateRoute, newPrice);
});


// Increase quantity
$(document).on('click', '.plus-btn', function (e) {
    e.preventDefault();
    let $row = $(this).closest('tr');
    let rowId = $row.data('row_id');
    let updateRoute = $row.data('update_route');
    let $qtyInput = $row.find('.cart-qty');
    let currentQty = parseInt($qtyInput.val());
    let newQty = currentQty + 1;
    $qtyInput.val(newQty);

    // Get the current price
    let currentPrice = parseFloat($row.find('.cart-price').val());

    if (isNaN(currentPrice) || currentPrice < 0) {
        toastr.error('Price can not be negative.');
        return;
    }
    updateCart(rowId, newQty, updateRoute, currentPrice);
});

// Decrease quantity
$(document).on('click', '.minus-btn', function (e) {
    e.preventDefault();
    let $row = $(this).closest('tr');
    let rowId = $row.data('row_id');
    let updateRoute = $row.data('update_route');
    let $qtyInput = $row.find('.cart-qty');
    let currentQty = parseInt($qtyInput.val());

    // Ensure quantity does not go below 1
    if (currentQty > 1) {
        let newQty = currentQty - 1;
        $qtyInput.val(newQty);

        // Get the current price
        let currentPrice = parseFloat($row.find('.cart-price').val());
        if (isNaN(currentPrice) || currentPrice < 0) {
            toastr.error('Price can not be negative.');
            return;
        }

        // Call updateCart with both qty and price
        updateCart(rowId, newQty, updateRoute, currentPrice);
    }
});

// Cart quantity input field change event
$(document).on('change', '.cart-qty', function () {
    let $row = $(this).closest('tr');
    let rowId = $row.data('row_id');
    let updateRoute = $row.data('update_route');
    let newQty = parseInt($(this).val());

    // Retrieve the cart price
    let currentPrice = parseFloat($row.find('.cart-price').val());
    if (isNaN(currentPrice) || currentPrice < 0) {
        toastr.error('Price can not be negative.');
        return;
    }

    // Ensure quantity does not go below 0
    if (newQty >= 0) {
        updateCart(rowId, newQty, updateRoute, currentPrice);
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
function updateCart(rowId, qty, updateRoute, price) {
    $.ajax({
        url: updateRoute,
        type: 'PUT',
        data: {
            rowId: rowId,
            qty: qty,
            price: price,
        },
        success: function (response) {
            if (response.success) {
                fetchUpdatedCart(calTotalAmount); // Refresh the cart and recalculate totals
            } else {
                toastr.error(response.message || 'Failed to update cart');
            }
        },
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

/** Handle customer selection change **/
$('.customer-select').on('change', function () {
    clearCart('sale'); // Clear cart and calculation

    let customer_type = $(this).find(':selected').data('type');
    let $customer_id = $(this).val();

    // Clear data in the payment section
    $('.payment-section input').val('');

    // Check if the customer value is "guest"
    if ($customer_id === 'guest') {
        $('.guest_phone').removeClass('d-none');

        // Reset product prices to their default (Retailer prices)
        $('.single-product').each(function () {
            let defaultPrice = $(this).data('default_price');
            $(this).find('.product_price').text(currencyFormat(defaultPrice));
        });
    } else {
        $('.guest_phone').addClass('d-none');
        $('.guest_phone input').val('');

        // Update product prices based on the selected customer type
        if (customer_type) {
            let url = $('#get_product').val();
            $.ajax({
                url: url,
                type: 'GET',
                data: { type: customer_type },
                success: function (data) {
                    $('.single-product').each(function () {
                        let productId = $(this).data('product_id');
                        if (data[productId]) {
                            $(this).find('.product_price').text(data[productId]);
                        }
                    });
                },
            });
        }
    }
});

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

    // Calculate subtotal from cart list using qty * price
    $('#cart-list tr').each(function () {
        let qty = getNumericValue($(this).find('.cart-qty').val()) || 0;
        let price = getNumericValue($(this).find('.cart-price').val()) || 0;
        let row_subtotal = qty * price;
        subtotal += row_subtotal;
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
    $('#change_amount').val(formattedAmount(change_amount, 2));

    // Due Amount
    let due_amount = total_amount > receive_amount ? total_amount - receive_amount : 0;
    $('#due_amount').val(formattedAmount(due_amount, 2));

}

calTotalAmount();

// Cancel btn action
$('.cancel-sale-btn').on('click', function (e) {
    e.preventDefault();
    clearCart('sale');
});


// Sidebar compress style
$('.side-bar, .section-container').toggleClass('active', window.innerWidth >= 1150);

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

// select brand or product action
$(document).on('click', '.category-list, .brand-list', function () {
    const isCategory = $(this).hasClass('category-list');
    const filterType = isCategory ? 'category_id' : 'brand_id';
    const filterId = $(this).data('id');
    const route = $(this).data('route'); // product filter route

    const searchTerm = $('#sale_product_search').val();

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

/** Add to cart start **/

// Debounce function to limit the frequency of API calls
function debounce(func, delay) {
    let timer;
    return function (...args) {
        const context = this;
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(context, args), delay);
    };
}

// Scanner detection variables
let isScannerInput = false;
let scannerInputTimeout;
const SCANNER_LOCK_TIME = 300; // Time to wait before allowing another scan

// Handle barcode scanner input (Enter key detection)
$('.product-filter').on('keydown', '.search-input', function (e) {
    if (e.key === 'Enter') {
        if (isScannerInput) {
            e.preventDefault();
            return; // Skip duplicate scanner calls
        }

        e.preventDefault(); // Prevent form submission

        handleScannerInput(this);
    }
});

// Handle the input event with debouncing
$('.product-filter').on('input', '.search-input', debounce(function () {
    if (isScannerInput) {
        return; // Skip input events triggered by scanner
    }

    handleUserInput();
}, 400));

// Function to handle scanner input
function handleScannerInput(inputElement) {
    isScannerInput = true; // Lock scanner input handling
    clearTimeout(scannerInputTimeout); // Reset scanner lock timer

    const form = $(inputElement).closest('form')[0];
    const customer_id = $('.customer-select').val();

    if (!customer_id) {
        toastr.warning('Please select a customer first!');
        resetScannerLock();
        return;
    }

    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: new FormData(form),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            if (res.total_products && res.product_id) {
                autoAddItemToCart(res.product_id);
            }
            $("#products-list").html(res.data); // Update the table with new data
        },
        complete: function () {
            resetScannerLock();
        }
    });
}

// Function to handle user input
function handleUserInput() {
    const customer_id = $('.customer-select').val();

    if (!customer_id) {
        toastr.warning('Please select a customer first!');
        return;
    }

    fetchProducts();
}

// Reset scanner lock after processing
function resetScannerLock() {
    scannerInputTimeout = setTimeout(() => {
        isScannerInput = false;
    }, SCANNER_LOCK_TIME);
}

// Fetch products function
function fetchProducts() {
    const form = $(".product-filter-form")[0];

    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: new FormData(form),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            if (res.total_products && res.product_id && res.total_products_count > 1) {
                autoAddItemToCart(res.product_id);
            }
            $("#products-list").html(res.data); // Update the table with new data
        }
    });
}

function autoAddItemToCart(id) {
    let element = $('#products-list').find('.single-product.' + id);
    addItemToCart(element);
};

$(document).on('click', '#single-product', function () {
    // Check if a customer is selected
    let customer_id = $('.customer-select').val();
    // If neither a valid customer is selected nor "Guest" is selected
    if (!customer_id) {
        toastr.warning('Please select a customer first!');
        return;
    }
    addItemToCart($(this));
});

function addItemToCart(element) {
    let url = element.data('route');
    let product_id = element.data('product_id');
    let product_name = element.find('.product_name').text();
    let product_price = getNumericValue(element.find('.product_price').text());
    let product_code = element.data('product_code');
    let product_unit_id = element.data('product_unit_id');
    let product_unit_name = element.data('product_unit_name');
    let product_image = element.data('product_image');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            type: 'sale',
            id: product_id,
            name: product_name,
            price: product_price,
            quantity: 1,
            product_code: product_code,
            product_unit_id: product_unit_id,
            product_unit_name: product_unit_name,
            product_image: product_image,
        },
        success: function (response) {
            if (response.success) {
                fetchUpdatedCart(calTotalAmount); // Update totals after cart fetch completes
                $("#sale_product_search").val('');
            } else {
                toastr.error(response.message);
            }
        },
        error: function (xhr) {
            console.error('Error:', xhr.responseText);
        }
    });
}

/** Add to cart End **/
