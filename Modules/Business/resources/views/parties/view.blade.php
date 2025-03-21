<div class="modal fade" id="parties-view">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('View') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body order-form-section">
                <div class="costing-list">
                    <ul>
                        <li><span>{{ __('Name') }}</span> <span>:</span> <span id="parties_name"></span></li>
                        <li><span>{{ __('Phone') }}</span> <span>:</span> <span id="parties_phone"></span></li>
                        <li><span>{{ __('Email') }}</span> <span>:</span> <span id="parties_email"></span></li>
                        <li><span>{{ __('Type') }}</span> <span>:</span> <span id="parties_type"></span></li>
                        <li><span>{{ __('Address') }}</span> <span>:</span> <span id="parties_address"></span></li>
                        <li><span>{{ __('Due') }}</span> <span>:</span> <span id="parties_due"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
