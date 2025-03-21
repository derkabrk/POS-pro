@extends('layouts.master')

@section('title')
    {{ __('Subscriptions List') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys ">
                <div class="table-header p-16">
                    <h4>{{ __('Subscriptions List') }}</h4>
                </div>
                <div class="table-top-form p-16-0">
                    <form action="{{ route('admin.subscription-reports.filter') }}" method="post" class="filter-form" table="#subscriber-data">
                        @csrf

                        <div class="table-top-left d-flex gap-3 margin-l-16">
                            <div class="gpt-up-down-arrow position-relative">
                                <select name="per_page" class="form-control">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                                <span></span>
                            </div>

                            <div class="table-search position-relative">
                                <input class="form-control" type="text" name="search"
                                    placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                                <span class="position-absolute">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                        </svg>

                                </span>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

            <div class="responsive-table m-0">
                <table class="table" id="datatable">
                    <thead>
                    <tr>
                        <th>{{ __('SL') }}.</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Shop Name') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Package') }}</th>
                        <th>{{ __('Started') }}</th>
                        <th>{{ __('End') }}</th>
                        <th>{{ __('Gateway Method') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody  id="subscriber-data" class="searchResults">
                        @include('admin.subscribers.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $subscribers->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection

<div class="modal fade" id="approve-modal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Are you sure?') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="" method="post" enctype="multipart/form-data"
                        class="add-brand-form pt-0 ajaxform_instant_reload modalApproveForm">
                        @csrf
                        <div class="row">
                            <div class="mt-3">
                                <label class="custom-top-label">{{ __('Enter Reason') }}</label>
                               <textarea name="notes" rows="2" class="form-control" placeholder="{{ __('Enter reason') }}"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <a href="" class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 {{-- View Modal --}}
<div class="modal fade" id="subscriber-view-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Subscriber View') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <img width="100px" width="100px" class="rounded-circle border-2 shadow" src="" id="image" alt="">
                        </div>
                    </div>
                    <div class="row align-items-center mt-4">
                        <div class="col-md-4"><p>{{ __('Business Name') }}</p></div>
                        <div class="col-1">
                            <p>:</p>
                        </div>
                        <div class="col-md-7"><p class="business_name"></p></div>
                    </div>

                    <div class="row align-items-center mt-3">
                        <div class="col-md-4"><p>{{ __('Business Category') }}</p></div>
                        <div class="col-1">
                            <p>:</p>
                        </div>
                        <div class="col-md-7"><p id="category"></p></div>
                    </div>

                    <div class="row align-items-center mt-3">
                        <div class="col-md-4"><p>{{ __('Package') }}</p></div>
                        <div class="col-1">
                            <p>:</p>
                        </div>
                        <div class="col-md-7"><p id="package"></p></div>
                    </div>
                    <div class="row align-items-center mt-3">
                        <div class="col-md-4"><p>{{ __('Gateway Name') }}</p></div>
                        <div class="col-1">
                            <p>:</p>
                        </div>
                        <div class="col-md-7"><p id="gateway"></p></div>
                    </div>

                    <div class="row align-items-center mt-3">
                        <div class="col-md-4"><p>{{ __('Enroll Date') }}</p></div>
                        <div class="col-1">
                            <p>:</p>
                        </div>
                        <div class="col-md-7"><p id="enroll_date"></p></div>
                    </div>

                    <div class="row align-items-center mt-3">
                        <div class="col-md-4"><p>{{ __('Expire date') }}</p></div>
                        <div class="col-1">
                            <p>:</p>
                        </div>
                        <div class="col-md-7"><p id="expired_date"></p></div>
                    </div>

                    <div class="row mt-2" id="manual_img">
                            <img width="100px" src="" id="manul_attachment" alt="">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
