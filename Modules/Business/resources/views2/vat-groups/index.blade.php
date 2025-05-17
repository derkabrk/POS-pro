<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-header">
                <h4>{{ __('Vat groups ( Combination of multiple vats ) ') }}</h4>
                <div>
                    <a href="{{ route('business.vats.create') }}" class="theme-btn print-btn text-light active"><i class="fas fa-plus-circle me-1"></i>{{ __('Add New') }}</a>
                </div>
            </div>


            <div class="table-top-form mt-3">
                <!---------- table top left left --------->
                <div class="table-top-left">
                    <div class="gpt-up-down-arrow position-relative">
                        <form action="{{ route('business.vat-groups.filter') }}" method="post" class="filter-form" table="#vat_group-data">
                            @csrf
                            <div class="table-search position-relative d-print-none">
                                <input class="form-control" name="search" type="text" placeholder="{{ __('Search...') }}">
                                <span class="position-absolute">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                        </svg>

                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="responsive-table">
            <table class="table" id="datatable">
                <thead>
                    <tr>
                        <th class="w-60">{{ __('SL') }}.</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Rate') }}</th>
                        <th>{{ __('Sub vats') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody id="vat_group-data">
                    @include('business::vat-groups.datas')
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $vat_groups->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

