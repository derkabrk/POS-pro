function formatNumber(value) {
    return value % 1 === 0 ? value.toFixed(0) : value.toFixed(2);
}

$(".view-btn").each(function () {
    let container = $(this);
    let id = container.data("id");

    // User View Modal
    $("#user_view_" + id).on("click", function () {
        $("#user_view_business_category").text(
            $("#user_view_" + id).data("business_category")
        );
        $("#user_view_business_name").text(
            $("#user_view_" + id).data("business_name")
        );

        let imageSrc = $("#user_view_" + id).data("image");
        $("#user_view_image").attr("src", imageSrc);
        $("#user_view_name").text($("#user_view_" + id).data("name"));
        $("#user_view_role").text($("#user_view_" + id).data("role"));
        $("#user_view_email").text($("#user_view_" + id).data("email"));
        $("#user_view_phone").text($("#user_view_" + id).data("phone"));
        $("#user_view_address").text($("#user_view_" + id).data("address"));
        $("#user_view_country_id").text(
            $("#user_view_" + id).data("country_id")
        );
        $("#user_view_statfeatures-listus").text(
            $("#user_view_" + id).data("status") == 1 ? "Active" : "Deactive"
        );
    });

    // Plan View Modal
    $("#plan_view_" + id).on("click", function () {
        let features = $("#plan_view_" + id).data("features");
        let featuresList = $("#features-list");

        featuresList.empty();

        features.forEach((feature) => {
            let featureHtml = `
                <div class="row align-items-center mt-3 feature-entry">
                    <div class="col-md-1">
                        <p id="plan_view_features_yes">
                            ${
                                feature.value == 1
                                    ? '<i class="fas fa-check-circle"></i>'
                                    : '<i class="fas fa-times-circle"></i>'
                            }
                        </p>
                    </div>
                    <div class="col-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p id="plan_view_features_name">${feature.name}</p>
                    </div>
                </div>
            `;

            featuresList.append(featureHtml);
        });
    });

    // Category View
    $("#category_view_" + id).on("click", function () {
        $("#category_view_name").text($("#category_view_" + id).data("name"));
        $("#category_view_description").text(
            $("#category_view_" + id).data("description")
        );
        $("#category_view_status").text(
            $("#category_view_" + id).data("status") == 1
                ? "Active"
                : "Deactive"
        );
    });
    // Faqs view
    $("#faqs_view_" + id).on("click", function () {
        $("#faqs_view_question").text($("#faqs_view_" + id).data("question"));
        $("#faqs_view_answer").text($("#faqs_view_" + id).data("answer"));
        $("#faqs_view_status").text(
            $("#faqs_view_" + id).data("status") == 1 ? "Active" : "Deactive"
        );
    });
});

//Business view modal
$(".business-view").on("click", function () {
    $(".business_name").text($(this).data("name"));
    $("#image").attr("src", $(this).data("image"));
    $("#name").text($(this).data("name"));
    $("#address").text($(this).data("address"));
    $("#category").text($(this).data("category"));
    $("#phone").text($(this).data("phone"));
    $("#package").text($(this).data("package"));
    $("#last_enroll").text($(this).data("last_enroll"));
    $("#expired_date").text($(this).data("expired_date"));
    $("#created_date").text($(this).data("created_date"));
});

$("#plan_id").on("change", function () {
    $(".plan-price").val($(this).find(":selected").data("price"));
});

$(document).on("change", ".file-input-change", function () {
    let prevId = $(this).data("id");
    newPreviewImage(this, prevId);
});

// image preview
function newPreviewImage(input, prevId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#" + prevId).attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

//Upgrade plan
$(".business-upgrade-plan").on("click", function () {
    var url = $(this).data("url");

    $("#business_name").val($(this).data("name"));
    $("#business_id").val($(this).data("id"));
    $(".upgradePlan").attr("action", url);
});

$(".modal-reject").on("click", function () {
    var url = $(this).data("url");
    $(".modalRejectForm").attr("action", url);
});

$(".modal-approve").on("click", function () {
    var url = $(this).data("url");
    $(".modalApproveForm").attr("action", url);
});

//edit banner
$(".edit-btn").each(function () {
    let container = $(this);
    let service = container.data("id");
    let id = service;
    $("#edit-banner-" + service).on("click", function () {
        $("#checkbox").prop(
            "checked",
            $("#edit-banner-" + service).data("status") == 1
        );
        $(".dynamic-text").text(
            $("#edit-banner-" + service).data("status") == 1
                ? "Active"
                : "Deactive"
        );

        let edit_action_route = $(this).data("url");
        $("#editForm").attr("action", edit_action_route + "/" + id);
    });
});

$(".edit-banner-btn").on("click", function () {
    let status = $(this).data("status");
    $(".edit-status").prop("checked", status);
    $(".edit-imageUrl-form").attr("action", $(this).data("url"));
    $("#edit-imageUrl").attr("src", $(this).data("image"));

    if (status == 1) {
        $(".dynamic-text").text("Active");
    } else {
        $(".dynamic-text").text("Deactive");
    }
});

$(function () {
    $("body").on("click", ".remove-one", function () {
        $(this).closest(".remove-list").remove();
    });
});
/** Subscriptions Plan end */

//Dynamic Tags Setting Start

$(document)
    .off("click", ".add-new-tag")
    .on("click", ".add-new-tag", function () {
        let html = `
    <div class="col-md-6">
        <div class="row row-items">
            <div class="col-sm-10">
                <label for="">Tags</label>
                <input type="text" name="tags[]" class="form-control" required
                    placeholder="Enter tags name">
            </div>
            <div class="col-sm-2 align-self-center mt-3">
                <button type="button" class="btn text-danger trash remove-btn-features"
                    onclick="removeDynamicField(this)"><i
                        class="fas fa-trash"></i></button>
            </div>
        </div>
    </div>
    `;
        $(".manual-rows .single-tags").append(html);
    });
//Dynamic tag ends

$(document).on("click", ".add-new-item", function () {
    let html = `
    <div class="row row-items">
        <div class="col-sm-5">
            <label for="">Label</label>
            <input type="text" name="manual_data[label][]" value="" class="form-control" placeholder="Enter label name">
        </div>
        <div class="col-sm-5">
            <label for="">Select Required/Optionl</label>
            <select class="form-control" required name="manual_data[is_required][]">
                <option value="1">Required</option>
                <option value="0">Optional</option>
            </select>
        </div>
        <div class="col-sm-2 align-self-center mt-3">
            <button type="button" class="btn text-danger trash remove-btn-features"><i class="fas fa-trash"></i></button>
        </div>
    </div>
    `;
    $(".manual-rows").append(html);
});

$(document).on("click", ".remove-btn-features", function () {
    var $row = $(this).closest(".row-items");
    $row.remove();
});

// Staff view Start
$(".staff-view-btn").on("click", function () {
    var staffName = $(this).data("staff-view-name");
    var staffPhone = $(this).data("staff-view-phone-number");
    var staffemail = $(this).data("staff-view-email-number");
    var staffRole = $(this).data("staff-view-role");

    $("#staff_view_name").text(staffName);
    $("#staff_view_phone_number").text(staffPhone);
    $("#staff_view_email_number").text(staffemail);
    $("#staff_view_role").text(staffRole);
});
// Staff view End

var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// subscription-plan-edit-custom-input size
const inputs = document.querySelectorAll(
    ".subscription-plan-edit-custom-input"
);

function resizeInput() {
    const tempSpan = document.createElement("span");
    tempSpan.style.visibility = "hidden";
    tempSpan.style.position = "absolute";
    tempSpan.style.whiteSpace = "pre";
    tempSpan.style.font = window.getComputedStyle(this).font;
    tempSpan.textContent = this.value || this.placeholder;

    document.body.appendChild(tempSpan);

    this.style.width = tempSpan.offsetWidth + 20 + "px"; // 20 mean by, left + right = 20px. please check css

    document.body.removeChild(tempSpan);
}

inputs.forEach(function (input) {
    input.addEventListener("input", resizeInput);
    resizeInput.call(input);
});

// ------------BUSINESS PANEL START ---------------------------------------------------------

$(".category-edit-btn").on("click", function () {
    var modal = $("#category-edit-modal");

    $("#category_name").val($(this).data("category-name"));
    $("#category_icon").attr("src", $(this).data("category-icon"));

    // Handle checkboxes for variations
    $("#capacityCheck").prop(
        "checked",
        $(this).data("category-variationcapacity") === 1
    );
    $("#colorCheck").prop(
        "checked",
        $(this).data("category-variationcolor") === 1
    );
    $("#sizeCheck").prop(
        "checked",
        $(this).data("category-variationsize") === 1
    );
    $("#typeCheck").prop(
        "checked",
        $(this).data("category-variationtype") === 1
    );
    $("#weightCheck").prop(
        "checked",
        $(this).data("category-variationweight") === 1
    );

    modal.find("form").attr("action", $(this).data("url"));
});

$(".units-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var unitName = $(this).data("units-name");
    var unitStatus = $(this).data("units-status");

    $("#unit_view_name").val(unitName);
    $("#unit_status").val(unitStatus);

    if (unitStatus == 1) {
        $("#unit_status").prop("checked", true);
        $(".dynamic-text").text("Active");
    } else {
        $("#unit_status").prop("checked", false);
        $(".dynamic-text").text("Deactive");
    }
    $(".unitUpdateForm").attr("action", url);
});

$(".brand-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var brand_name = $(this).data("brands-name");
    var brand_icon = $(this).data("brands-icon");
    var brand_description = $(this).data("brands-description");

    $("#brand_view_name").val(brand_name);
    $("#edit_icon").attr("src", brand_icon);
    $("#brand_view_description").val(brand_description);

    $(".brandUpdateForm").attr("action", url);
});

/** Product Start */
$("#category-select").on("change", function () {
    // Get selected category and its data attributes
    var selectedCategory = $(this).find("option:selected");
    var capacity = parseInt(selectedCategory.data("capacity"));
    var color = parseInt(selectedCategory.data("color"));
    var size = parseInt(selectedCategory.data("size"));
    var type = parseInt(selectedCategory.data("type"));
    var weight = parseInt(selectedCategory.data("weight"));

    $("#dynamic-fields").empty();

    // Conditionally add fields only if they exist in the database
    if (capacity === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Capacity</label><input type="text" name="capacity" class="form-control" placeholder="Enter capacity"></div>'
        );
    }
    if (color === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Color</label><input type="text" name="color" class="form-control" placeholder="Enter color"></div>'
        );
    }
    if (size === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Size</label><input type="text" name="size" class="form-control" placeholder="Enter size"></div>'
        );
    }
    if (type === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Type</label><input type="text" name="type" class="form-control" placeholder="Enter type"></div>'
        );
    }
    if (weight === 1) {
        $("#dynamic-fields").append(
            '<div class="form-group col-lg-6"><label>Weight</label><input type="text" name="weight" class="form-control" placeholder="Enter weight"></div>'
        );
    }
});

$(document).ready(function () {
    // Initial check if category is pre-selected
    var initialCategory = $("#category-select-edit").find("option:selected");
    handleCategoryChange(initialCategory);

    // Handle category selection change
    $("#category-select-edit").change(function () {
        var selectedCategory = $(this).find("option:selected");
        handleCategoryChange(selectedCategory);
    });

    function handleCategoryChange(selectedCategory) {
        // Get selected category and its data attributes
        var capacity = parseInt(selectedCategory.data("capacity"));
        var color = parseInt(selectedCategory.data("color"));
        var size = parseInt(selectedCategory.data("size"));
        var type = parseInt(selectedCategory.data("type"));
        var weight = parseInt(selectedCategory.data("weight"));

        // Clear existing dynamic fields
        $("#dynamic-fields-edit").empty();

        // Conditionally add fields only if they exist for the selected category
        if (capacity === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Capacity</label>
                    <input type="text" name="capacity" class="form-control" placeholder="Enter capacity" value="${$(
                        "#capacity-value"
                    ).val()}">
                </div>
            `);
        }
        if (color === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control" placeholder="Enter color" value="${$(
                        "#color-value"
                    ).val()}">
                </div>
            `);
        }
        if (size === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Size</label>
                    <input type="text" name="size" class="form-control" placeholder="Enter size" value="${$(
                        "#size-value"
                    ).val()}">
                </div>
            `);
        }
        if (type === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Type</label>
                    <input type="text" name="type" class="form-control" placeholder="Enter type" value="${$(
                        "#type-value"
                    ).val()}">
                </div>
            `);
        }
        if (weight === 1) {
            $("#dynamic-fields-edit").append(`
                <div class="form-group col-lg-6">
                    <label>Weight</label>
                    <input type="text" name="weight" class="form-control" placeholder="Enter weight" value="${$(
                        "#weight-value"
                    ).val()}">
                </div>
            `);
        }
    }
});

$(".product-view").on("click", function () {
    $("#product_name").text($(this).data("name"));
    $("#product_code").text($(this).data("code"));
    $("#product_brand").text($(this).data("brand"));
    $("#product_category").text($(this).data("category"));
    $("#product_unit").text($(this).data("unit"));
    $("#product_purchase_price").text($(this).data("purchase-price"));
    $("#product_sale_price").text($(this).data("sale-price"));
    $("#product_wholesale_price").text($(this).data("wholesale-price"));
    $("#product_dealer_price").text($(this).data("dealer-price"));
    $("#product_stock").text($(this).data("stock"));
    $("#product_low_stock").text($(this).data("low-stock"));
    $("#expire_date").text($(this).data("expire-date"));
    $("#product_manufacturer").text($(this).data("manufacturer"));

    const product_image = $(this).data("image");
    $("#product_image").attr("src", product_image);
});

//vat calculation
function updatePrices() {
    let vatRate =
        parseFloat($("#vat_id").find(":selected").data("vat_rate")) || 0;
    let exclusivePrice = parseFloat($("#exclusive_price").val()) || 0;
    let profitMargin = parseFloat($("#profit_margin").val()) || 0;
    let vatType = $("#vat_type").val();

    // inclusive price (Always includes vat)
    let inclusivePrice = exclusivePrice + (exclusivePrice * vatRate) / 100;

    // Calculate mrp based on vat type
    let mrp = exclusivePrice;
    if (vatType === "inclusive") {
        mrp += (exclusivePrice * vatRate) / 100;
    }

    mrp += (mrp * profitMargin) / 100;

    $("#inclusive_price").val(formatNumber(inclusivePrice));
    $("#mrp_price").val(formatNumber(mrp));
}

$("#vat_id, #vat_type, #exclusive_price, #profit_margin").on(
    "change input",
    updatePrices
);

$("#mrp_price").on("input", function () {
    let vatType = $("#vat_type").val();
    let vatRate =
        parseFloat($("#vat_id").find(":selected").data("vat_rate")) || 0;
    let exclusivePrice = parseFloat($("#exclusive_price").val()) || 0;
    let mrp = parseFloat($("#mrp_price").val()) || 0;

    if (exclusivePrice > 0 && mrp > 0) {
        let basePrice = exclusivePrice;

        if (vatType === "inclusive") {
            basePrice *= 1 + vatRate / 100;
        }

        let profitMargin = (mrp / basePrice - 1) * 100;
        $("#profit_margin").val(formatNumber(profitMargin));
    }
});

$("#inclusive_price").on("input", function () {
    let vatRate =
        parseFloat($("#vat_id").find(":selected").data("vat_rate")) || 0;
    let inclusivePrice = parseFloat($(this).val()) || 0;

    let exclusivePrice = inclusivePrice / (1 + vatRate / 100);

    $("#exclusive_price").val(formatNumber(exclusivePrice));

    // Delay user to finish input
    inclusivePriceTimer = setTimeout(() => {
        updatePrices();
    }, 900);
});

/** Product End */

$(".parties-view-btn").on("click", function () {
    $("#parties_name").text($(this).data("name"));
    $("#parties_phone").text($(this).data("phone"));
    $("#parties_email").text($(this).data("email"));
    $("#parties_type").text($(this).data("type"));
    $("#parties_address").text($(this).data("address"));
    $("#parties_due").text($(this).data("due"));
});

$(".income-categories-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var name = $(this).data("income-categories-name");
    var description = $(this).data("income-categories-description");

    $("#income_categories_view_name").val(name);
    $("#income_categories_view_description").val(description);

    $(".incomeCategoryUpdateForm").attr("action", url);
});

$(".expense-categories-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var expense_name = $(this).data("expense-categories-name");
    var expense_description = $(this).data("expense-categories-description");

    $("#expense_categories_view_name").val(expense_name);
    $("#expense_categories_view_description").val(expense_description);

    $(".expenseCategoryUpdateForm").attr("action", url);
});

$(".incomes-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var income_category_id = $(this).data("income-category-id");
    var incomeAmount = $(this).data("income-amount");
    var incomeFor = $(this).data("income-for");
    var incomePaymentType = $(this).data("income-payment-type");
    var incomePaymentTypeId = $(this).data("income-payment-type-id");
    var incomeReferenceNo = $(this).data("income-reference-no");
    var incomedate = $(this).data("income-date-update");
    var incomenote = $(this).data("income-note");

    $("#income_categoryId").val(income_category_id);
    $("#inc_price").val(incomeAmount);
    $("#inc_for").val(incomeFor);
    if (
        incomePaymentTypeId !== null &&
        incomePaymentTypeId !== undefined &&
        incomePaymentTypeId !== ""
    ) {
        $("#inc_paymentType").val(incomePaymentTypeId);
    } else {
        $("#inc_paymentType").val(incomePaymentType);
    }
    $("#incomeReferenceNo").val(incomeReferenceNo);
    $("#inc_date_update").val(incomedate);
    $("#inc_note").val(incomenote);

    $(".incomeUpdateForm").attr("action", url);
});

$(".expense-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var expenseCategoryId = $(this).data("expense-category-id");
    var expenseAmount = $(this).data("expense-amount");
    var expensePaymentType = $(this).data("expense-payment-type");
    var expensePaymentTypeId = $(this).data("expense-payment-type-id");
    var expenseReferenceNo = $(this).data("expense-reference-no");
    var expenseFor = $(this).data("expense-for");
    var expenseDate = $(this).data("expense-date");
    var expenseNote = $(this).data("expense-note");

    // Set the values in the modal's fields
    $("#expenseCategoryId").val(expenseCategoryId);
    $("#expense_amount").val(expenseAmount);
    if (
        expensePaymentTypeId !== null &&
        expensePaymentTypeId !== undefined &&
        expensePaymentTypeId !== ""
    ) {
        $("#expensePaymentType").val(expensePaymentTypeId);
    } else {
        $("#expensePaymentType").val(expensePaymentType);
    }
    $("#refeNo").val(expenseReferenceNo);
    $("#expe_for").val(expenseFor);
    $("#edit_date_expe").val(expenseDate);
    $("#expenote").val(expenseNote);

    // Update the form action attribute
    $(".expenseUpdateForm").attr("action", url);
});

function showTab(tabId) {
    const tabs = document.querySelectorAll(".tab-item");
    tabs.forEach((tab) => tab.classList.remove("active"));

    const contents = document.querySelectorAll(".tab-content");
    contents.forEach((content) => content.classList.remove("active"));

    document.getElementById(tabId).classList.add("active");
    document
        .querySelector(`[onclick="showTab('${tabId}')"]`)
        .classList.add("active");
}

// Multidelete Start
function updateSelectedCount() {
    var selectedCount = $(".delete-checkbox-item:checked").length;
    $(".selected-count").text(selectedCount);

    if (selectedCount > 0) {
        $(".delete-show").removeClass("d-none");
    } else {
        $(".delete-show").addClass("d-none");
    }
}

$(".select-all-delete").on("click", function () {
    $(".delete-checkbox-item").prop("checked", this.checked);
    updateSelectedCount();
});

$(document).on("change", ".delete-checkbox-item", function () {
    updateSelectedCount();
});

$(".trigger-modal").on("click", function () {
    var dynamicUrl = $(this).data("url");

    $("#dynamic-delete-form").attr("action", dynamicUrl);

    var ids = $(".delete-checkbox-item:checked")
        .map(function () {
            return $(this).val();
        })
        .get();

    if (ids.length === 0) {
        alert("Please select at least one item.");
        return;
    }

    var form = $("#dynamic-delete-form");
    form.find("input[name='ids[]']").remove();
    ids.forEach(function (id) {
        form.append('<input type="hidden" name="ids[]" value="' + id + '">');
    });
});

$(".create-all-delete").on("click", function (event) {
    event.preventDefault();

    var form = $("#dynamic-delete-form");
    form.submit();
});

// Multidelete End

// Collects Due Start
$("#invoiceSelect").on("change", function () {
    const selectedOption = $(this).find("option:selected");
    const dueAmount = selectedOption.data("due-amount");
    const openingDue = selectedOption.data("opening-due");

    if (!selectedOption.val()) {
        $("#totalAmount").val(openingDue);
        $("#dueAmount").val(openingDue);
    } else {
        $("#totalAmount").val(dueAmount);
        $("#dueAmount").val(dueAmount);
    }

    calculateDueChange();
});

$("#paidAmount").on("input", function () {
    calculateDueChange();
});
function calculateDueChange() {
    const payingAmount = parseFloat($("#paidAmount").val()) || 0;
    const totalAmount = parseFloat($("#totalAmount").val()) || 0;

    if (payingAmount > totalAmount) {
        toastr.error("cannot pay more than due.");
    }

    const updatedDueAmount = totalAmount - payingAmount;
    $("#dueAmount").val(updatedDueAmount >= 0 ? updatedDueAmount : 0);
}
// Collects Due End

//Subscriber view modal
$(".subscriber-view").on("click", function () {
    $(".business_name").text($(this).data("name"));
    $("#image").attr("src", $(this).data("image"));
    $("#category").text($(this).data("category"));
    $("#package").text($(this).data("package"));
    $("#gateway").text($(this).data("gateway"));
    $("#enroll_date").text($(this).data("enroll"));
    $("#expired_date").text($(this).data("expired"));
    $("#manul_attachment").attr("src", $(this).data("manul-attachment"));
});

/** barcode: start **/
$("#product-search").on("keyup click", function () {
    const query = $(this).val().toLowerCase();
    const fetchRoute = $("#fetch-products-route").val();
    // Fetch matching products
    $.ajax({
        url: fetchRoute,
        type: "GET",
        data: { search: query },
        dataType: "json",
        success: function (data) {
            let productList = "";
            if (data.length > 0) {
                data.forEach((product) => {
                    productList += `
                            <li
                                class="list-group-item product-item"
                                data-id="${product.id}"
                                data-name="${product.productName}"
                                data-code="${product.productCode}"
                                data-stock="${product.productStock}">
                                ${product.productName} (${product.productCode})
                            </li>`;
                });
            } else {
                productList =
                    '<li class="list-group-item text-danger">No products found.</li>';
            }
            $("#search-results").html(productList).show();
        },
        error: function () {
            console.log("Unable to fetch products. Please try again later.");
        },
    });
});

// Hide search results when clicking outside
$(document).on("click", function (e) {
    if (!$(e.target).closest("#product-search, #search-results").length) {
        $("#search-results").hide();
    }
});

// When a product is selected from the list
$(document).on("click", ".product-item", function () {
    const productId = $(this).data("id");
    const productName = $(this).data("name");
    const productCode = $(this).data("code");
    const productStock = $(this).data("stock");

    // Add the product to the table if not already added
    if (!$('#product-list tr[data-id="' + productId + '"]').length) {
        const newRow = `
            <tr data-id="${productId}">
                <td class="text-start">${productName}</td>
                <td>${productCode}</td>
                <td>${productStock}</td>
                <td class="large-td">
                    <div class="d-flex align-items-center justify-content-center">
                        <button class="incre-decre sub-btn"><i class="fas fa-minus icon"></i></button>
                        <input type="number" name="qty[]" value="1" class="custom-number-input pint-qty" placeholder="0">
                        <button class="incre-decre add-btn"><i class="fas fa-plus icon"></i></button>
                    </div>
                </td>
                <td class="large-td">
                    <input type="date" name="preview_date[]"  class="form-control input-date">
                </td>
                <td>
                    <button class="x-btn remove-btn text-danger">
                        <i class="far fa-times "></i>
                    </button>
                </td>
              <input type="hidden" name="product_ids[]" value="${productId}">
            </tr>`;
        $("#product-list").append(newRow);
    }

    $("#search-results").hide();
    $("#product-search").val("");
});

$(document).on("click", ".remove-btn", function () {
    $(this).closest("tr").remove();
});

// Increase quantity
$(document).on("click", ".add-btn", function (e) {
    e.preventDefault();
    const qtyInput = $(this).siblings(".pint-qty");
    let currentQty = parseInt(qtyInput.val(), 10) || 0;
    qtyInput.val(currentQty + 1);
});

// Decrease quantity
$(document).on("click", ".sub-btn", function (e) {
    e.preventDefault();
    const qtyInput = $(this).siblings(".pint-qty");
    let currentQty = parseInt(qtyInput.val(), 10) || 1;
    if (currentQty > 1) {
        qtyInput.val(currentQty - 1);
    }
});

let $savingLoader1 =
        '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
    $barcodeForm = $(".barcodeForm");

$barcodeForm.initFormValidation(),
    $(document).on("submit", ".barcodeForm", function (e) {
        e.preventDefault();
        let t = $(this).find("#barcode-preview-btn"),
            a = t.html();

        if ($barcodeForm.valid()) {
            $.ajax({
                type: "POST",
                url: this.action,
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    t.html($savingLoader1).attr("disabled", true);
                },
                success: function (e) {
                    t.html(a).removeClass("disabled").attr("disabled", false);

                    if (e.secondary_redirect_url) {
                        // Open the print page and trigger window.print()
                        let printWindow = window.open(
                            e.secondary_redirect_url,
                            "_blank"
                        );

                        if (printWindow) {
                            printWindow.onload = function () {
                                printWindow.print();
                            };
                        }
                    }

                    if (e.redirect) {
                        location.href = e.redirect;
                    }
                },
                error: function (e) {
                    t.html(a).attr("disabled", false);
                },
            });
        }
    });

/** Barcode: end **/

//Vat start
$(".vat-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var name = $(this).data("vat-name");
    var rate = $(this).data("vat-rate");
    var newrate = $(this).data("new-vat-rate");
    var status = $(this).data("vat-status");

    $("#vat_name").val(name);
    $("#vat_rate").val(rate);
    $("#new_vat_rate").val(newrate);
    $("#vat_status").val(status);
    $(".updateVatForm").attr("action", url);
});
//Vat End

/** Report Filter: Start **/

// Handle Custom Date Selection
$(".custom-days").on("change", function () {
    let selected = $(this).val();
    let dateFilters = $(".date-filters");

    // Show or hide the date filters based on selection
    if (selected === "custom_date") {
        dateFilters.removeClass("d-none");
    } else {
        dateFilters.addClass("d-none");
    }

    // Trigger the form submission to apply the filters
    $(".report-filter-form").trigger("input");
});
// Report Filter Form Submission
$(".report-filter-form").on("input change", function (e) {
    e.preventDefault();
    let form = $(this);
    let table = form.attr("table");

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            $(table).html(res.data);
            if (res.total_sale !== undefined) {
                $("#total_sale").text(res.total_sale);
            }
            if (res.total_sale_return !== undefined) {
                $("#total_sale_return").text(res.total_sale_return);
            }
            if (res.total_purchase !== undefined) {
                $("#total_purchase").text(res.total_purchase);
            }
            if (res.total_purchase_return !== undefined) {
                $("#total_purchase_return").text(res.total_purchase_return);
            }
            if (res.total_income !== undefined) {
                $("#total_income").text(res.total_income);
            }
            if (res.total_expense !== undefined) {
                $("#total_expense").text(res.total_expense);
            }
            if (res.total_loss !== undefined) {
                $("#total_loss").text(res.total_loss);
            }
            if (res.total_profit !== undefined) {
                $("#total_profit").text(res.total_profit);
            }
            if (res.total_sale_count !== undefined) {
                $("#total_sale_count").text(res.total_sale_count);
            }
            if (res.total_due !== undefined) {
                $("#total_due").text(res.total_due);
            }
            if (res.total_paid !== undefined) {
                $("#total_paid").text(res.total_paid);
            }
        },
    });
});
/** Report Filter: End **/

// When the user clicks on the show/hide icon
$(".hide-show-icon").click(function () {
    let input = $(this).siblings("input");
    let showIcon = $(this).find(".showIcon");
    let hideIcon = $(this).find(".hideIcon");

    input.attr("type", input.attr("type") === "password" ? "text" : "password");

    showIcon.toggleClass("d-none");
    hideIcon.toggleClass("d-none");
});

// Payment Type Edit Start
$(".payment-types-edit-btn").on("click", function () {
    var url = $(this).data("url");
    var PaymentTypeName = $(this).data("payment-types-name");
    var PaymentTypeStatus = $(this).data("payment-types-status");

    $("#PaymentTypeName").val(PaymentTypeName);
    $("#PaymentTypeStatus").val(PaymentTypeStatus);

    $(".paymentTypeUpdateForm").attr("action", url);
});
// Payment Type Edit End
