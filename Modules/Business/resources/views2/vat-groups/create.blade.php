@extends('business::layouts.master')

@section('title')
    {{ __('Vat Group') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{ __('Add New Vat Group') }}</h4>
                        <div>
                            <a href="{{ route('business.vats.index') }}" class="theme-btn print-btn text-light active"><i class="fas fa-list me-1"></i>{{ __('Vat Group List') }}</a>
                        </div>
                    </div>

                    <div class="order-form-section p-16">
                        {{-- form start --}}
                        <form action="{{ route('business.vats.store') }}" method="post" enctype="multipart/form-data"
                        class="ajaxform_instant_reload">
                        @csrf

                        <div class="add-suplier-modal-wrapper">
                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Vat Group Name') }}</label>
                                    <input type="text" name="name" id="name" required class="form-control"
                                        placeholder="{{ __('Enter Name') }}">
                                </div>


                                <div class="col-md-6 mt-2">
                                    <label>{{ __('Select vats') }}</label>
                                    <div class="input-group">
                                        <select id="sub_vat" name="vat_ids[]" class="form-control" multiple>
                                            @foreach ($vats as $vat)
                                                <option value="{{ $vat->id }}">{{ $vat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-2 col-lg-6">
                                    <label class="custom-top-label">{{ __('Status') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select class="form-control form-selected" name="status">
                                            <option value="1">{{ __('Active') }}</option>
                                            <option value="0">{{ __('Deactive') }}</option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="offcanvas-footer mt-3 d-flex justify-content-center">
                                    <a href="{{ route('business.vats.index') }}" class="cancel-btn btn btn-outline-danger">{{ __('Cancel') }}</a>
                                    <button class="submit-btn btn btn-primary text-white" type="submit">{{ __('Save') }}</button>
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

@push('js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $('#sub_vat').select2({
            placeholder: 'Select vats',
        });
    </script>
@endpush
