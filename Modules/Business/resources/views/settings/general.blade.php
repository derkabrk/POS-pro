@extends('business::layouts.master')

@section('title')
    {{ __('Settings') }}
@endsection

@section('content')
    <div class="erp-table-section py-4">
        <div class="container-fluid">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="table-header mb-4 d-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-0 text-primary"><i class="ri-settings-3-line me-2"></i>{{ __('Settings') }}</h4>
                    </div>
                    <div class="order-form-section">
                        <form action="{{ route('business.settings.update', $setting->id ?? 0) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="add-suplier-modal-wrapper d-block">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <label class="form-label fw-semibold text-white">{{ __('Business Category') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="business_category_id" class="form-select rounded-3 shadow-sm">
                                                <option value="">{{ __('Select a category') }}</option>
                                                @foreach ($business_categories as $category)
                                                    <option value="{{ $category->id }}" @selected($business->business_category_id == $category->id)>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label fw-semibold text-white">{{ __('Company And Business Name') }}</label>
                                        <input type="text" name="companyName" value="{{ $business->companyName }}" class="form-control rounded-3 shadow-sm" placeholder="{{ __('Enter Title') }}">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label fw-semibold text-white">{{ __('Phone Number') }}</label>
                                        <input type="number" name="phoneNumber" value="{{ $business->phoneNumber }}" class="form-control rounded-3 shadow-sm" placeholder="{{ __('Enter Phone') }}">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label fw-semibold text-white">{{ __('Address') }}</label>
                                        <input type="text" name="address" value="{{ $business->address }}" class="form-control rounded-3 shadow-sm" placeholder="{{ __('Enter Address') }}">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label fw-semibold text-white">{{ __('VAT/GST Title') }}</label>
                                        <input type="text" name="vat_name" value="{{ $business->vat_name }}" class="form-control rounded-3 shadow-sm" placeholder="{{ __('Enter VAT/GST Title') }}">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label fw-semibold text-white">{{ __('VAT/GST Number') }}</label>
                                        <input type="text" name="vat_no" value="{{ $business->vat_no }}" class="form-control rounded-3 shadow-sm" placeholder="{{ __('Enter VAT/GST Number') }}">
                                    </div>
                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="form-label fw-semibold text-white mb-2">{{ __('Invoice Logo') }}</label>
                                        <div class="upload-img-v2 d-flex align-items-center gap-3 p-3 bg-light rounded-3 shadow-sm border border-1">
                                            <label class="upload-v4 settings-upload-v4 m-0 position-relative" style="cursor:pointer;">
                                                <div class="img-wrp rounded-3 border border-2 overflow-hidden" style="width: 90px; height: 90px; background: #fff; display: flex; align-items: center; justify-content: center;">
                                                    <img src="{{ asset($setting->value['invoice_logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="invoice_logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                </div>
                                                <input type="file" name="invoice_logo" accept="image/*" onchange="document.getElementById('invoice_logo').src = window.URL.createObjectURL(this.files[0])" class="form-control d-none">
                                                <span class="position-absolute bottom-0 end-0 bg-white text-primary rounded-circle p-1" style="font-size: 1.2rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                                    <i class="ri-upload-2-line"></i>
                                                </span>
                                            </label>
                                            <div class="flex-grow-1">
                                                <div class="small text-muted mb-1">{{ __('Recommended: 200x200px, PNG/JPG') }}</div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 text-white border-white" onclick="document.querySelector('input[name=invoice_logo]').click();"><i class="ri-upload-cloud-2-line me-1 text-white"></i>{{ __('Change') }}</button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 text-white border-white" onclick="document.getElementById('invoice_logo').src='{{ asset('assets/images/icons/upload-icon.svg') }}'; document.querySelector('input[name=invoice_logo]').value='';"><i class="ri-delete-bin-6-line me-1 text-white"></i>{{ __('Remove') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-center mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow submit-btn text-white"><i class="ri-save-3-line me-2 text-white"></i>{{ __('Update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
