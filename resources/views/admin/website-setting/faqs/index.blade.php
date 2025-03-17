@extends('layouts.master')

@section('title')
    {{__('FAQS List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{ __('FAQs List') }}</h4>
                        <a href="{{ route('admin.faqs.create') }}" class="theme-btn print-btn text-light">
                            <i class="far fa-plus" aria-hidden="true"></i>
                            {{ __('Create New') }}
                        </a>
                    </div>
                    <div class="table-top-form">
                        <form action="{{ route('admin.faqs.index') }}" method="post">
                            @csrf
                            <div class="table-search">
                                <input class="form-control searchInput" type="text" name="search" placeholder="{{ __('Search') }}..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <div class="responsive-table">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    @can('faqs-delete')
                                    <th class="w-60">
                                        <div class="d-flex align-items-center gap-3" >
                                            <input type="checkbox" class="selectAllCheckbox">
                                            <i class="fal fa-trash-alt delete-selected"></i>
                                        </div>
                                    </th>
                                    @endcan
                                    <th>{{ __('SL') }}.</th>
                                    <th>{{ __('Question') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="searchResults">
                                @include('admin.website-setting.faqs.datas')
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">{{ $faqs->links('pagination::bootstrap-5') }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modal')
    @include('admin.components.multi-delete-modal')

    <div class="modal fade" id="view-single-details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('View Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 mt-3">
                        <label for="view-question" class="form-label fw-bold">{{ __('Question') }}:</label>
                        <h6 id="view-question"></h6>
                    </div>
                    <div class="mb-3">
                        <label for="view-answer" class="form-label fw-bold">{{ __('Answer') }}:</label>
                        <p id="view-answer"></p>
                    </div>
                    <div class="mb-3">
                        <label for="view-status" class="form-label fw-bold">{{ __('Status') }}:</label>
                        <p id="view-status"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
