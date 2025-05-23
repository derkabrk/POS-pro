@extends('business::layouts.master')

@section('title')
    {{ __('Sales List') }}
@endsection

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@component('components.breadcrumb')
@slot('li_1') Business @endslot
@slot('title') Sales @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="salesList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Sales History') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <div class="ms-2">
                                <form action="{{ route('business.sales.import.csv') }}" method="POST" enctype="multipart/form-data" id="import-csv-form">
                                    @csrf
                                    <input type="file" name="csv_file" id="import-csv-input" accept=".csv" style="display: none;" onchange="document.getElementById('import-csv-form').submit();">
                                    <label for="import-csv-input" class="btn btn-info" style="cursor:pointer;">
                                        <i class="ri-file-download-line align-bottom me-1"></i> {{ __('Import CSV') }}
                                    </label>
                                    <span id="csv-file-name" class="ms-2 text-secondary" style="font-size: 0.95em;"></span>
                                </form>
                            </div>
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.sales.filter') }}" method="post" class="filter-form" table="#sales-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-5 col-sm-6">
                            <div class="search-box">
                                <input type="text" name="search" class="form-control search" placeholder="{{ __('Search for tracking, party name, status or something...') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select name="per_page" class="form-control" data-choices data-choices-search-false>
                                    <option value="">{{ __('Show Records') }}</option>
                                    <option value="10" selected>{{ __('Show- 10') }}</option>
                                    <option value="25">{{ __('Show- 25') }}</option>
                                    <option value="50">{{ __('Show- 50') }}</option>
                                    <option value="100">{{ __('Show- 100') }}</option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select name="sale_type" id="sale_type_filter" class="form-control" data-choices data-choices-search-false>
                                    <option value="">{{ __('Sale Type') }}</option>
                                    <option value="" selected>{{ __('All Sales') }}</option>
                                    <option value="0">{{ __('Physical Sale') }}</option>
                                    <option value="1">{{ __('E-commerce Sale') }}</option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select name="order_source_id" id="order_source_filter" class="form-control" data-choices data-choices-search-false>
                                    <option value="">{{ __('Order Source') }}</option>
                                    <option value="" selected>{{ __('All Order Sources') }}</option>
                                    @foreach($orderSources as $orderSource)
                                        <option value="{{ $orderSource->id }}">{{ $orderSource->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <button type="button" class="btn btn-primary w-100" onclick="SearchData();">
                                    <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    {{ __('Filters') }}
                                </button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>

            <div class="card-body pt-0">
                <div class="delete-item delete-show d-none">
                    <div class="delete-item-show">
                        <p class="fw-bold"><span class="selected-count"></span> {{ __('items selected') }}</p>
                        <button data-bs-toggle="modal" class="btn btn-danger trigger-modal" data-bs-target="#multi-delete-modal" data-url="{{ route('business.sales.delete-all') }}">
                            <i class="ri-delete-bin-2-line me-1"></i>{{ __('Delete Selected') }}
                        </button>
                    </div>
                </div>

                <div class="table-responsive table-card mb-1">
                    <table class="table table-nowrap align-middle" id="salesTable">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th scope="col" style="width: 25px;">
                                    <div class="form-check">
                                        <input class="form-check-input select-all-delete multi-delete" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                <th class="sort" data-sort="sl">{{ __('SL') }}.</th>
                                <th class="sort" data-sort="date">{{ __('Date') }}</th>
                                <th class="sort" data-sort="tracking">{{ __('Tracking') }}</th>
                                <th class="sort" data-sort="party_name">{{ __('Party Name') }}</th>
                                <th class="sort" data-sort="total">{{ __('Total') }}</th>
                                <th class="sort" data-sort="sale_type">{{ __('Sale Type') }}</th>
                                <th class="sort" data-sort="delivery_type">{{ __('Delivery Type') }}</th>
                                <th class="sort" data-sort="payment">{{ __('Payment') }}</th>
                                <th class="sort" data-sort="status">{{ __('Status') }}</th>
                                <th class="sort" data-sort="action">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all" id="sales-data">
                            @include('business::sales.datas')
                        </tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                            </lord-icon>
                            <h5 class="mt-2">{{ __('Sorry! No Result Found') }}</h5>
                            <p class="text-muted">{{ __('We\'ve searched through all sales records. We did not find any sales matching your search criteria.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <div class="pagination-wrap hstack gap-2">
                        {{ $sales->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<script>
    document.getElementById('import-csv-input').addEventListener('change', function(){
        const fileName = this.files[0] ? this.files[0].name : '';
        document.getElementById('csv-file-name').textContent = fileName;
    });

    document.addEventListener("DOMContentLoaded", function () {
        const saleTypeFilter = document.getElementById("sale_type_filter");
        const filterForm = document.querySelector(".filter-form");
        const salesData = document.getElementById("sales-data");

        saleTypeFilter.addEventListener("change", function () {
            const formData = new FormData(filterForm);

            fetch(filterForm.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    salesData.innerHTML = data.html;
                } else {
                    salesData.innerHTML = "<tr><td colspan='11' class='text-center'>{{ __('No Sales Found') }}</td></tr>";
                }
            })
            .catch(error => console.error("Error fetching sales data:", error));
        });
    });

    function SearchData() {
        const filterForm = document.querySelector(".filter-form");
        const salesData = document.getElementById("sales-data");
        const formData = new FormData(filterForm);

        fetch(filterForm.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                salesData.innerHTML = data.html;
            } else {
                salesData.innerHTML = "<tr><td colspan='11' class='text-center'>{{ __('No Sales Found') }}</td></tr>";
            }
        })
        .catch(error => console.error("Error fetching sales data:", error));
    }

    function deleteMultiple() {
        const checkedItems = document.querySelectorAll('.multi-delete:checked');
        if (checkedItems.length > 0) {
            document.querySelector('.trigger-modal').click();
        }
    }
</script>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

@push('modal')
    @include('business::component.delete-modal')
@endpush