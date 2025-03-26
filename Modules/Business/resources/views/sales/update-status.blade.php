<div class="modal fade" id="updateStatusModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update Sale Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="{{ route('business.sales.updatestatus') }}" method="post" enctype="multipart/form-data"
                        class="ajaxform_instant_reload">
                        @csrf
                        <input type="hidden" id="saleId" name="sale_id">
                    <label for="sale_status">Select New Status:</label>
                    <select id="sale_status" name="sale_status" class="form-control">
                        @foreach (\App\Models\Sale::STATUS as $id => $status)
                            <option value="{{ $id }}">{{ $status['name'] }}</option>
                        @endforeach
                    </select>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-3">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    let saleIdInput = document.getElementById("saleId");  // Hidden input for sale_id
    let saleStatusSelect = document.getElementById("sale_status");  // Dropdown for status
    let saveStatusBtn = document.getElementById("saveStatusBtn");  // Save button

    // Handle "Update Status" button click
    document.querySelectorAll(".update-status-btn").forEach(button => {
        button.addEventListener("click", function () {
            let saleId = this.getAttribute("data-sale-id");  // Get sale_id from button
            let currentStatus = this.getAttribute("data-current-status");  // Get current status

            saleIdInput.value = saleId;
            saleStatusSelect.value = currentStatus;  
        });
    });

    // Handle "Save Status" button click
    saveStatusBtn.addEventListener("click", function () {
        let saleId = saleIdInput.value;
        let newStatus = saleStatusSelect.value;
    });
});
</script>