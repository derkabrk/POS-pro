@extends('business::layouts.master')

@section('title')
{{ __('Purchase Return List') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card" id="purchaseReturnList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Purchase Return List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <!-- Add new purchase return button if needed -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.purchase-returns.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3" table="#purchase-return-data">
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
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input type="text" name="search" class="form-control search" placeholder="{{ __('Search...') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="purchaseReturnTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th scope="col">{{ __('SL') }}.</th>
                                <th scope="col">{{ __('Invoice No') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col">{{ __('Party') }}</th>
                                <th scope="col">{{ __('Total Amount') }}</th>
                                <th scope="col">{{ __('Paid Amount') }}</th>
                                <th scope="col">{{ __('Return Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody id="purchase-return-data">
                            @include('business::purchase-returns.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $purchases->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



