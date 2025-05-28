@extends('business::layouts.master')

@section('title')
    Shipping Services
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Add New Shipping Service')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('business.shipping.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('Shipping List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('business.shipping.store') }}" enctype="multipart/form-data" method="POST" class="ajaxform_instant_reload">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label fw-semibold">Platform Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required class="form-control" placeholder="Company Name">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label fw-semibold">Select Service <span class="text-danger">*</span></label>
                                    <select name="shipping_company_id" id="shipping_company" class="form-select">
                                        <option value="">Select Service</option>
                                        @foreach ($shipping_companys as $shipping_company)
                                            <option value="{{ $shipping_company->id }}"
                                                data-credential="{{ $shipping_company->first_r_credential_lable}}"
                                                data-label="{{ $shipping_company->first_r_credential_lable}}"
                                                data-second-credential="{{ $shipping_company->second_r_credential_lable}}"
                                                data-second-label="{{ $shipping_company->second_r_credential_lable}}">
                                                {{ ucfirst($shipping_company->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label" id="first_r_credential_lable"></label>
                                    <input type="text" name="first_r_credential" class="form-control" placeholder="Please select a shipping service" id="first_r_credential_input">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label" id="second_r_credential_lable"></label>
                                    <input type="text" name="second_r_credential" class="form-control" placeholder="Please select a shipping service" id="second_r_credential_input">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <span class="dynamic-text mb-0">{{ __('Active') }}</span>
                                        <label class="switch m-0">
                                            <input type="checkbox" name="status" value="1" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectAllStepdesk = document.getElementById("selectAllStepdesk");
        const selectAllDeliveryHome = document.getElementById("selectAllDeliveryHome");

        selectAllStepdesk.addEventListener("change", function () {
            document.querySelectorAll(".stepdesk-checkbox").forEach(checkbox => {
                checkbox.checked = selectAllStepdesk.checked;
            });
        });

        selectAllDeliveryHome.addEventListener("change", function () {
            document.querySelectorAll(".delivery-checkbox").forEach(checkbox => {
                checkbox.checked = selectAllDeliveryHome.checked;
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        
        const selectElement = document.getElementById("shipping_company");

        // First Credential Elements
        const firstInput = document.getElementById("first_r_credential_input");
        const firstLabel = document.getElementById("first_r_credential_lable");

        // Second Credential Elements
        const secondInput = document.getElementById("second_r_credential_input");
        const secondLabel = document.getElementById("second_r_credential_lable");




        selectElement.addEventListener("change", function() {
            let selectedOption = selectElement.options[selectElement.selectedIndex];

            let firstCredential = selectedOption.getAttribute("data-credential");
            let firstCredentialLabel = selectedOption.getAttribute("data-label");

            let secondCredential = selectedOption.getAttribute("data-second-credential");
            let secondCredentialLabel = selectedOption.getAttribute("data-second-label");

            console.log("First Credential:", firstCredential);
console.log("First Credential Label:", firstCredentialLabel);
console.log("Second Credential:", secondCredential);
console.log("Second Credential Label:", secondCredentialLabel);

            // Update first required credential
            if (firstCredential && firstCredentialLabel) {
                firstLabel.textContent = firstCredentialLabel;
                secondLabel.textContent = secondCredentialLabel;
                firstInput.value = firstCredential;
            } else {
                firstLabel.textContent = "";
                firstInput.value = "";
            }

            // Update second required credential
            if (secondCredential && secondCredentialLabel) {
                secondLabel.textContent = secondCredentialLabel;
                secondInput.value = secondCredential;
            } else {    
                secondLabel.textContent = "";
                secondInput.value = "";
            }
        });
    });
</script>

<style>
    /* Hide default checkbox */
    input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #8c68cd;
        border-radius: 4px;
        background-color: #e4e5e7;
        cursor: pointer;
        position: relative;
    }

    /* Checkbox when checked */
    input[type="checkbox"]:checked {
        background-color: #8c68cd;
        border: 2px solid #8c68cd;
    }

    /* Checkmark */
    input[type="checkbox"]::before {
        content: "✔";
        color: white;
        font-size: 14px;
        font-weight: bold;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    input[type="checkbox"]:checked::before {
        display: block;
    }
</style>
