"use strict";

/** confirm modal start */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.confirm-action', function (event) {
    event.preventDefault();
    let url = $(this).data('action') ?? $(this).attr('href');
    let method = $(this).data('method') ?? 'POST';
    let icon = $(this).data('icon') ?? 'fas fa-warning';

    $.confirm({
        title: "Are you sure?",
        icon: icon,
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        type: 'red',
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                action: function () {
                    event.preventDefault();
                    $.ajax({
                        type: method,
                        url: url,
                        success: function (response) {
                            if (response.redirect) {
                                window.sessionStorage.hasPreviousMessage = true;
                                window.sessionStorage.previousMessage = response.message ?? null;

                                location.href = response.redirect;
                            } else {
                                Notify('success', response)
                            }
                        },
                        error: function (xhr, status, error) {
                            Notify('error', xhr)
                        }
                    })
                }
            },
            close: {
                action: function () {
                    this.buttons.close.hide()
                }
            }
        },
    });
});
/**confirm modal end */

/** filter all from start */
$('.filter-form').on('change', function (e) {
    var table = $(this).attr('table');
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            $(table).html(res.data);
        }
    });
});

/** filter all from  end */

/** DELETE ACTION */
$(document).on("click", ".delete-confirm", function (e) {
    e.preventDefault();
    let t = $(this),
        o = t.attr("href") ?? t.data("action"),
        i = t.html();

        // Create modal dynamically
    let confirmationModal = `
        <div class="modal fade" id="delete-confirmation-modal" tabindex="-1" aria-labelledby="delete-confirmation-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-end">
                        <button type="button" class="btn-close m-3 mb-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="delete-modal text-center mb-lg-4">
                            <h5>Are You Sure?</h5>
                            <p>You won't be able to revert this!</p>
                        </div>
                         <div class="d-flex justify-content-center">
                            <div class="button-group">
                                <button class="btn reset-btn border rounded" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn theme-btn border rounded delete-confirmation-button">Yes, Delete It!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    $('body').append(confirmationModal); // Append modal to the body
    $('#delete-confirmation-modal').modal('show');

    // handle dynamic modal
    $('.delete-confirmation-button').on('click', function () {
        $.ajax({
            url: o,
            data: { _token: CSRF_TOKEN },
            type: "DELETE",
            beforeSend: function () {
                t.html($savingLoader).attr('disabled', true);
            },
            success: function (e) {
                t.html(i).removeClass("disabled").attr("disabled", false);
                ajaxSuccess(e, t);

            },
            error: function (e) {
                t.html(i).removeClass("disabled").attr("disabled", false);
                Notify(e);
            },
        });

        // Hide and remove modal
        $('#delete-confirmation-modal').modal('hide');
        $('#delete-confirmation-modal').remove();
    });
});

// Listen for input changes and update feature values accordingly
$('#words_limit').on('input', function () {
    $('#word_feature').val($('#words_limit').val() + ' Word Limit');
});

$('#images_limit').on('input', function () {
    $('#image_feature').val($('#images_limit').val() + ' images Limit');
});

$(document).ready(function () {
    $('.logoutButton').on('click', function() {
        document.getElementById('logoutForm').submit();
    });
})




