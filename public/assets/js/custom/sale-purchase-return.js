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

// Get numeric value from string
function getNumericValue(value) {
    return parseFloat(value.replace(/[^0-9.-]+/g, "")) || 0;
}

updateTotalAmount();

// Update quantity on manual change
$(document).on('change', '.return-qty', function() {
    var row = $(this).closest('tr');
    var currentQtyInput = $(this);
    var currentQty = getNumericValue(currentQtyInput.val());
    var maxQty = parseInt(row.data('max_qty'));

    // Validate the entered quantity
    if (currentQty > maxQty) {
        toastr.error('You cannot return more than the ordered quantity.');
    } else if (currentQty < 0) {
        toastr.error('Return quantity cannot be less than 0.');
    }

    updateSubTotal(row);
});


// Increase quantity
$(document).on('click', '.add-btn', function(e) {
    e.preventDefault();

    // Find the closest row and get current quantity and max quantity
    var row = $(this).closest('tr');
    var currentQtyInput = row.find('.return-qty');
    var currentQty = getNumericValue(currentQtyInput.val());
    var maxQty = parseInt(row.data('max_qty'));

    // Check if the current quantity exceeds max allowed
    if (currentQty < maxQty) {
        currentQtyInput.val(currentQty + 1);
        updateSubTotal(row);
    } else {
        toastr.error('You cannot return more than the ordered quantity.');
    }
});

// Decrease quantity
$(document).on('click', '.sub-btn', function(e) {
    e.preventDefault();

    // Find the closest row and get current quantity
    var row = $(this).closest('tr');
    var currentQtyInput = row.find('.return-qty');
    var currentQty = getNumericValue(currentQtyInput.val());

    // return quantity cannot negative
    if (currentQty > 0) {
        currentQtyInput.val(currentQty - 1);
        updateSubTotal(row);
    } else {
        toastr.error('Return quantity cannot be negative.');
    }
});

// Update the subtotal for each row based on the return quantity
function updateSubTotal(row) {
    var price = getNumericValue(row.find('.price').text());
    var quantity = getNumericValue(row.find('.return-qty').val());
    var subTotal = price * quantity;

    row.find('.subtotal').text(currencyFormat(subTotal));
    updateTotalAmount();
}

// Update total return amount
function updateTotalAmount() {
    var totalReturn = 0;
    $('.subtotal').each(function() {
        totalReturn += getNumericValue($(this).text());
    });

    // Display total return amount
    $('.return_amount').text('Return Amount ' + currencyFormat(totalReturn));
}
