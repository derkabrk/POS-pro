@extends('business::layouts.master')

@section('title')
    {{ __('Edit Vat Group') }}
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
                        <h4>{{ __('Edit Vat Group') }}</h4>
                    </div>

                    <div class="order-form-section p-16">
                        {{-- form start --}}
                        <form action="{{ route('business.vats.update',$vat->id) }}" method="post" enctype="multipart/form-data"
                            class="ajaxform_instant_reload">
                            @csrf
                            @method('PUT')

                            <div class="add-suplier-modal-wrapper">
                                <div class="row">
                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Vat Group Name') }}</label>
                                        <input type="text" name="name" value="{{ $vat->name }}" required
                                            class="form-control" placeholder="{{ __('Enter Name') }}">
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label>{{ __('Select vats') }}</label>
                                        <div class="input-group">
                                            <select id="sub_vat" name="vat_ids[]" class="form-control" multiple>
                                                @php
                                                    $selectedVatIds = collect($vat->sub_vat)->pluck('id')->toArray();
                                                @endphp

                                                @foreach ($vats as $vat_item)
                                                    <option value="{{ $vat_item->id }}" @selected(in_array($vat_item->id, $selectedVatIds))>
                                                        {{ $vat_item->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="mt-2 col-lg-6">
                                        <label class="custom-top-label">{{ __('Status') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select class="form-control form-selected" name="status">
                                                <option value="1" @selected($vat->status == 1)>{{ __('Active') }}</option>
                                                <option value="0" @selected($vat->status == 0)>{{ __('Deactive') }}</option>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="offcanvas-footer mt-3 d-flex justify-content-center">
                                        <a href="{{ route('business.vats.index') }}" class="cancel-btn btn btn-outline-danger">{{ __('Cancel') }}</a>
                                        <button class="submit-btn btn btn-primary text-white" type="submit">{{ __('Update') }}</button>
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
