@extends('business::layouts.master')

@section('title')
    {{ __('Sales List') }}
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="admin-table-section">
        <div class="container-fluid">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="table-header p-3">
                        <h4 class="mb-0">{{ __('Sales List') }}</h4>
                    </div>
                    <div class="table-top-form p-3">
                        <form action="{{ route('business.sales.filter') }}" method="post" class="filter-form" table="#sales-data">
                            @csrf
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-group">
                                    <select name="per_page" class="form-control">
                                        <option value="10">{{ __('Show- 10') }}</option>
                                        <option value="25">{{ __('Show- 25') }}</option>
                                        <option value="50">{{ __('Show- 50') }}</option>
                                        <option value="100">{{ __('Show- 100') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="sale_type" id="sale_type_filter" class="form-control">
                                        <option value="">{{ __('All Sales') }}</option>
                                        <option value="0">{{ __('Physical Sale') }}</option>
                                        <option value="1">{{ __('E-commerce Sale') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="order_source_id" id="order_source_filter" class="form-control">
                                        <option value="">{{ __('All Order Sources') }}</option>
                                        @foreach($orderSources as $orderSource)
                                            <option value="{{ $orderSource->id }}">{{ $orderSource->account_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group position-relative">
                                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                                    <span class="position-absolute search-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </form>

                        <div class="ms-2">
                            <form action="{{ route('business.sales.import.csv') }}" method="POST" enctype="multipart/form-data" id="import-csv-form">
                                @csrf
                                <input type="file" name="csv_file" id="import-csv-input" accept=".csv" style="display: none;" onchange="document.getElementById('import-csv-form').submit();">
                                <label for="import-csv-input" class="btn btn-outline-primary d-flex align-items-center gap-2 mb-0" style="cursor:pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                        <rect width="18" height="18" x="3" y="3" fill="#0d6efd" rx="4"/>
                                        <path fill="#fff" d="M12 7v6m0 0v4m0-4h4m-4 0H8"/>
                                    </svg>
                                    {{ __('Import CSV') }}
                                </label>
                                <span id="csv-file-name" class="ms-2 text-secondary" style="font-size: 0.95em;"></span>
                            </form>
                        </div>

                        <script>
                            document.getElementById('import-csv-input').addEventListener('change', function(){
                                const fileName = this.files[0] ? this.files[0].name : '';
                                document.getElementById('csv-file-name').textContent = fileName;
                            });
                        </script>
                    </div>
                </div>

                <div class="delete-item delete-show d-none">
                    <div class="delete-item-show">
                        <p class="fw-bold"><span class="selected-count"></span> {{ __('items show') }}</p>
                        <button data-bs-toggle="modal" class="trigger-modal" data-bs-target="#multi-delete-modal" data-url="{{ route('business.sales.delete-all') }}">{{ __('Delete') }}</button>
                    </div>
                </div>

                <div class="responsive-table m-0">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th class="w-60">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" class="select-all-delete multi-delete ">
                                    </div>
                                </th>
                                <th>{{ __('SL') }}.</th>
                                <th class="text-start">{{ __('Date') }}</th>
                                <th class="text-start">{{ __('Tracking') }}</th>
                                <th class="text-start">{{ __('Party Name') }}</th>
                                <th class="text-start">{{ __('Total') }}</th>
                                <th class="text-start">{{ __('Sale Type') }}</th>
                                @php
                                    $showPaidColumn = false;
                                @endphp

                                @foreach($sales as $sale)
                                    @if($sale->sale_type != 0)
                                        @php
                                            $showPaidColumn = true;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach

                                @if (!$showPaidColumn)
                                    @foreach($salesWithReturns as $sale)
                                        @if($sale->sale_type != 0)
                                            @php
                                                $showPaidColumn = true;
                                                break;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif

                                <th class="text-start">{{ __('Delivery Type') }}</th>
                                <th class="text-start">{{ __('Payment') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="sales-data">
                            @include('business::sales.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $sales->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script>
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
                        salesData.innerHTML = "<tr><td colspan='10' class='text-center'>No Sales Found</td></tr>";
                    }
                })
                .catch(error => console.error("Error fetching sales data:", error));
            });
        });
    </script>
@endsection

@push('modal')
    @include('business::component.delete-modal')
@endpush
