@extends('layouts.master')
@section('title')
    @lang('translation.funnel')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Apexcharts
        @endslot
        @slot('title')
            Funnel Charts
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Funnel Chart</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="funnel_chart" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Pyramid</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div>
                        <div id="pyramid_chart"
                            data-colors='["--vz-info", "--vz-danger", "--vz-primary", "--vz-secondary", "--vz-success", "--vz-dark", "--vz-warning"]'
                            class="apex-charts" dir="ltr"></div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- funnel charts init -->
    <script src="{{ URL::asset('build/js/pages/apexcharts-funnel.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
