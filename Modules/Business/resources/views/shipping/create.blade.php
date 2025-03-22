@extends('business::layouts.master')

@section('title')
    {{ __('Category') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Add New Service</h4>
                 
                        <a href="{{ route('business.shipping.index') }}" class="add-order-btn rounded-2 {{ Route::is('business.shipping.create') ? 'active' : '' }}"><i class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}</a>
                    
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('business.shipping.store') }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>Platform Name</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Company Name">
                                </div>


                                <div class="col-lg-6 mb-2">
                                    <label> Select Service </label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="shipping_company_id"
                                                class="form-control table-select w-100 role">
                                            <option value="">  Select Service </option>
                                            @foreach ($shipping_companys as $shipping_company)
                                                <option value="{{ $shipping_company->id }}"> {{ ucfirst($shipping_company->name) }} </option>
                                            @endforeach
                                        </select>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>First Required Credential</label>
                                    <input type="text" name="first_r_credential" class="form-control" placeholder="Enter First Required Credential">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Second Required Credential</label>
                                    <input type="text" name="second_r_credential" class="form-control" placeholder="Enter Second Required Credential">
                                </div>

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                                        <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get select and input elements
        const selectElement = document.querySelector("select[name='shipping_company_id']");
        const inputElement = document.querySelector("input[name='first_r_credential']");

        // Add event listener on select change
        selectElement.addEventListener("change", function() {
            inputElement.value = selectElement.options[selectElement.selectedIndex].text.trim(); // Set text of selected option
        });
    });
</script>

@endsection
