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
  let saleIdInput = document.getElementById("saleId");
    let saleStatusSelect = document.getElementById("sale_status");
    let saveStatusBtn = document.getElementById("saveStatusBtn");

    // Define valid transitions for each status
    const statusTransitions = {
        1: [2, 6, 7],  // Pending -> Called 1, Confirmed, Canceled
        2: [3, 6, 7],  // Called 1 -> Called 2, Confirmed, Canceled
        3: [4, 6, 7],  // Called 2 -> Called 3, Confirmed, Canceled
        4: [5, 7],     // Called 3 -> Called 4, Canceled
        5: [7],        // Called 4 -> Canceled
        6: [8, 7],     // Confirmed -> Shipping, Canceled
        8: [9, 10],    // Shipping -> Delivered, Returned
        9: [11],       // Delivered -> Paid
        11: [12]       // Paid -> Cash Out
    };

    // Open Modal and Set Allowed Statuses
    document.querySelectorAll(".update-status-btn").forEach(button => {
        button.addEventListener("click", function () {
            let saleId = this.getAttribute("data-sale-id");
            let currentStatus = parseInt(this.getAttribute("data-current-status"));

            saleIdInput.value = saleId;

            // Clear previous options
            saleStatusSelect.innerHTML = "";

            // Get allowed status transitions
            let allowedStatuses = statusTransitions[currentStatus] || [];

            // Add only allowed statuses
            Object.entries(statusMappings).forEach(([id, status]) => {
                if (allowedStatuses.includes(parseInt(id))) {
                    let option = document.createElement("option");
                    option.value = id;
                    option.textContent = status;
                    saleStatusSelect.appendChild(option);
                }
            });
        });
    });

    saveStatusBtn.addEventListener("click", function () {
        let saleId = saleIdInput.value;
        let newStatus = saleStatusSelect.value;

        if (!saleId || !newStatus) {
            alert("Invalid Sale ID or Status!");
            return;
        }
    });

</script>