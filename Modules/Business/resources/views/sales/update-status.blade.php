<div class="modal fade" id="updateStatusModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update Sale Statu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="{{ route('business.sales.updateStatus') }}" method="post" enctype="multipart/form-data"
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
