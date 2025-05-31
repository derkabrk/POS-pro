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
                            <!-- Options will be dynamically populated -->
                        </select>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-3">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button type="submit" class="theme-btn m-2 submit-btn" id="saveStatusBtn">{{ __('Save') }}</button>
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
    let saleIdInput = document.getElementById("saleId");  
    let saleStatusSelect = document.getElementById("sale_status"); 
    let saveStatusBtn = document.getElementById("saveStatusBtn"); 

    // Fix: Use correct selector for status button
    document.querySelectorAll(".status-btn").forEach(button => {
        button.addEventListener("click", function () {
            let saleId = this.getAttribute("data-sale-id"); 
            let currentStatus = this.getAttribute("data-current-status");

            saleIdInput.value = saleId;  

            // Fetch allowed statuses dynamically
            fetch(`/business/sales/next-statuses/${currentStatus}`)
                .then(response => response.json())
                .then(data => {
                    saleStatusSelect.innerHTML = "";

                    data.forEach(status => {
                        let option = document.createElement("option");
                        option.value = status.id;
                        option.textContent = status.name;
                        saleStatusSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching statuses:", error));
        });
    });
});
</script>

<style>
/* Enhanced Modal Design */
#updateStatusModal .modal-content {
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(60,60,60,0.15);
    border: none;
}
#updateStatusModal .modal-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 1rem 1rem 0 0;
}
#updateStatusModal .modal-title {
    font-weight: 600;
    color: #405189;
}
#updateStatusModal .modal-body label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}
#updateStatusModal .form-control {
    border-radius: 0.5rem;
    font-size: 1rem;
}
#updateStatusModal .button-group .theme-btn {
    min-width: 120px;
    font-size: 1rem;
    border-radius: 0.5rem;
}
</style>
