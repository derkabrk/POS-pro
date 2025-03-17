(function ($) {
    "use strict";

    /**
     * Checkbox: Select All
     */
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });

    /**
     * Toggle Period Duration
     */
    $("#is_period").on("change", function () {
        if ($(this).val() == 1) {
            $(".period_duration").removeClass("d-none");
        } else {
            $(".period_duration").addClass("d-none");
        }
    });

    /**
     * Dismiss Notification
     */
    $(".anna-dismiss").on("click", function () {
        $(".top-header-area").fadeOut();
    });

    /**
     * Form Validation Initialization
     */
    $.fn.initFormValidation = function () {
        let validator = $(this).validate({
            errorClass: "error",
            highlight: function (element, errorClass) {
                let $element = $(element);

                if ($element.hasClass("select2-hidden-accessible")) {
                    $("#select2-" + $element.attr("id") + "-container").parent().addClass(errorClass);
                } else if ($element.parents().hasClass("image-checkbox")) {
                    Notify("error", null, $element.parent().data("required"));
                } else {
                    $element.addClass(errorClass);
                }
            },
            unhighlight: function (element, errorClass) {
                let $element = $(element);

                if ($element.hasClass("select2-hidden-accessible")) {
                    $("#select2-" + $element.attr("id") + "-container").parent().removeClass(errorClass);
                } else {
                    $element.removeClass(errorClass);
                }
            },
            errorPlacement: function (error, element) {
                let $element = $(element);

                if ($element.hasClass("select2-hidden-accessible")) {
                    let container = $("#select2-" + $element.attr("id") + "-container").parent();
                    error.insertAfter(container);
                } else if ($element.parent().hasClass("form-floating")) {
                    error.insertAfter($element.parent().css("color", "text-danger"));
                } else if ($element.parent().hasClass("input-group")) {
                    error.insertAfter($element.parent());
                } else {
                    error.insertAfter($element);
                }
            },
        });

        $(this).on("select2:select", function () {
            if (!$.isEmptyObject(validator.submitted)) {
                validator.form();
            }
        });
    };

    /**
     * Select2 Initialization
     */
    function initializeSelect2() {
        if (typeof jQuery !== "undefined" && $.fn.select2 !== undefined) {
            document
                .querySelectorAll('[data-control="select2"]')
                .forEach((element) => {
                    let options = {
                        dir: document.body.getAttribute("direction"),
                    };

                    if (element.getAttribute("data-hide-search") === "true") {
                        options.minimumResultsForSearch = Infinity;
                    }

                    if (element.hasAttribute("data-placeholder")) {
                        options.placeholder = element.getAttribute("data-placeholder");
                    }

                    $(document).ready(function () {
                        $(element).select2(options);
                    });
                });

            $(document).on("select2:open", function () {
                let searchFields = document.querySelectorAll(".select2-container--open .select2-search__field");
                if (searchFields.length > 0) {
                    searchFields[searchFields.length - 1].focus();
                }
            });
        }
    }

    /**
     * Handle Session Message on Page Load
     */
    $(document).ready(function () {
        if (window.sessionStorage.hasPreviousMessage === "true") {
            Notify(window.sessionStorage?.notifyType ?? "success", null, window.sessionStorage.previousMessage, window.sessionStorage.redirect);
            window.sessionStorage.hasPreviousMessage = false;
            window.sessionStorage.notifyType = "success";
        }

        initializeSelect2();
    });

    /**
     * Select All Checkbox Functionality
     */
    if ($("#selectAll").length > 0) {
        let selectAll = document.querySelector("#selectAll");
        let checkboxes = document.querySelectorAll('[type="checkbox"]');

        selectAll.addEventListener("change", (event) => {
            checkboxes.forEach((checkbox) => {
                checkbox.checked = event.target.checked;
            });
        });
    }
})(jQuery);
