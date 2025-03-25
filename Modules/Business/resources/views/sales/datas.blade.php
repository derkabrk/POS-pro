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
        class="btn btn-sm {{  $status['color'] }} text-white px-2 py-1 rounded-pill update-status"
        data-sale-id="{{ $sale->id }}"
        data-current-status="{{ $sale->sale_status }}"
        >
        {{ $status['name'] }}
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".update-status").forEach(button => {
            button.addEventListener("click", function () {
                let saleId = this.dataset.saleId;
                let currentStatus = this.dataset.currentStatus;

                let statusOptions = {
                    1: "Pending", 2: "Called 1", 3: "Called 2", 4: "Called 3", 
                    5: "Called 4", 6: "Canceled", 7: "Confirmed", 8: "Shipping", 
                    9: "Returned", 10: "Delivered", 11: "Paid", 12: "Cash Out"
                };

                let selectHTML = '<select id="statusDropdown" class="form-control">';
                for (const [id, name] of Object.entries(statusOptions)) {
                    selectHTML += `<option value="${id}" ${id == currentStatus ? 'selected' : ''}>${name}</option>`;
                }
                selectHTML += '</select>';

                Swal.fire({
                    title: "Update Sale Status",
                    html: selectHTML,
                    showCancelButton: true,
                    confirmButtonText: "Update",
                    preConfirm: () => {
                        return document.getElementById("statusDropdown").value;
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        let newStatus = result.value;

                        // Send AJAX request to update status
                        fetch(`/business/sales/update-status/${saleId}`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ sale_status: newStatus })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload(); // Reload page to reflect change
                            } else {
                                Swal.fire("Error", "Failed to update status", "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error updating sale status:", error);
                            Swal.fire("Error", "Something went wrong", "error");
                        });
                    }
                });
            });
        });
    });
</script>
