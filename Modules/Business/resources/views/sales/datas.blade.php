@foreach($sales as $sale)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item multi-delete" value="{{ $sale->id }}">
        </td>
        <td>{{ $loop->iteration }}</td>
        <td class="text-start">{{ $sale->created_at->format('d M, Y') }}</td>
        <td class="text-start">{{ $sale->invoiceNumber }}</td>
        <td class="text-start">{{ $sale->party->name ?? 'N/A' }}</td>
        <td class="text-start">${{ number_format($sale->totalAmount, 2) }}</td>
        <td class="text-start">{{ $sale->sale_type == 0 ? 'Business' : 'E-commerce' }}</td>
        <td class="text-start">${{ number_format($sale->paidAmount, 2) }}</td>
        <td class="text-start">${{ number_format($sale->dueAmount, 2) }}</td>
        <td class="text-start">{{ $sale->payment_type_id != null ? $sale->payment_type->name ?? '' : $sale->paymentType }}</td>
        @if ($sale->sale_type == 1)
        @php
        $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
        @endphp
        <td>

        <button 
        class="btn btn-sm {{  $status['color'] }} text-white px-2 py-1 rounded-pill update-status-btn"
        data-bs-toggle="modal"
        data-bs-target="#updateStatusModal"
        data-sale-id="{{ $sale->id}}"
        data-current-status="{{ $sale->sale_status }}"
         >
        {{ $status['name']  }}
    </button>
        </td>
        @endif

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="{{ route('business.sales.invoice', $sale->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            Invoice
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.sale-returns.create', ['sale_id' => $sale->id]) }}">
                            <i class="fal fa-undo-alt"></i>
                            Sales Return
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>

   
@endforeach


@push('modal')
    @include('business::sales.update-status')
@endpush

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let saleIdInput = document.getElementById("saleId");
        let saleStatusSelect = document.getElementById("sale_status");
        let saveStatusBtn = document.getElementById("saveStatusBtn");

        document.querySelectorAll(".update-status-btn").forEach(button => {
            button.addEventListener("click", function () {
                let saleId = this.getAttribute("data-sale-id");
                let currentStatus = this.getAttribute("data-current-status");

                saleIdInput.value = saleId;
                saleStatusSelect.value = currentStatus;
            });
        });

        saveStatusBtn.addEventListener("click", function () {
            let saleId = saleIdInput.value;
            let newStatus = saleStatusSelect.value;

            if (!saleId || !newStatus) {
                alert("Invalid Sale ID or Status!");
                return;
            }

            saveStatusBtn.disabled = true;
            saveStatusBtn.innerHTML = "Updating...";

            // **Use Laravel's route helper to ensure the correct URL**
            let updateUrl = "{{ route('business.sales.updateStatus') }}";

            fetch(updateUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    sale_id: saleId,
                    sale_status: newStatus 
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.json();
            })
            .then(data => {
                saveStatusBtn.disabled = false;
                saveStatusBtn.innerHTML = "Update Status";

                if (data.success) {
                    alert("Sale status updated successfully!");
                    location.reload();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => {
                saveStatusBtn.disabled = false;
                saveStatusBtn.innerHTML = "Update Status";
                console.error("Error updating sale status:", error);
                alert("Something went wrong. Check the console for details.");
            });
        });
    });
</script>



