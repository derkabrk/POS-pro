@extends('layouts.master')
@section('title')
    @lang('translation.slope')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Apexcharts
        @endslot
        @slot('title')
            Slope Charts
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Basic Chart</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="basic_charts" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts"
                        dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Multi Group</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div>
                        <div id="multi_charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger"]'
                            class="apex-charts" dir="ltr"></div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- slope charts init -->
    <script src="{{ URL::asset('build/js/pages/apexcharts-slope.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
