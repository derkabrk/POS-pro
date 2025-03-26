

<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Sale Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('business.sales.updateStatus') }}" method="POST" enctype="multipart/form-data"
                        class="ajaxform_instant_reload">
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
            <div class="col-lg-12">
                            <div class="button-group text-center mt-3">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
        </div>
    </div>
</div>