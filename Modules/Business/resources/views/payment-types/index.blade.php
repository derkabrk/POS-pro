@extends('business::layouts.master')

@section('title')
    {{ __('Payment Type List') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card" id="paymentTypeList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Payment Type List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <a type="button" href="#payment-types-create-modal" data-bs-toggle="modal"
                                class="btn btn-primary btn-sm rounded-pill"><i class="ri-add-circle-line me-1"></i>{{ __('Add new Payemnt Type') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.payment-types.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3" table="#payment-types-data">
                    @csrf
                    <div class="row g-3 w-100">
                        <div class="col-xxl-2 col-sm-6">
                            <select name="per_page" class="form-control">
                                <option value="10">{{__('Show- 10')}}</option>
                                <option value="25">{{__('Show- 25')}}</option>
                                <option value="50">{{__('Show- 50')}}</option>
                                <option value="100">{{__('Show- 100')}}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="paymentTypeTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th class="w-60">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" class="select-all-delete multi-delete">
                                    </div>
                                </th>
                                <th>{{ __('SL') }}.</th>
                                <th class="text-start">{{ __('Name') }}</th>
                                <th class="text-start">{{ __('Status') }}</th>
                                <th class="text-start">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="payment-types-data">
                            @include('business::payment-types.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $paymentTypes->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::payment-types.create')
    @include('business::payment-types.edit')
@endpush
