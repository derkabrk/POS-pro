

<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Sale Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm">
                    @csrf
                    <input type="hidden" id="saleId" name="sale_id">
                    <label for="sale_status">Select New Status:</label>
                    <select id="sale_status" name="sale_status" class="form-control">
                        @foreach (\App\Models\Sale::STATUS as $id => $status)
                            <option value="{{ $id }}">{{ $status['name'] }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveStatusBtn">Update Status</button>
            </div>
        </div>
    </div>
</div>