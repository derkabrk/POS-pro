@extends('layouts.master')

@section('title')
    {{ __('Create Blog') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('Create Blog') }}</h4>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-list me-1"></i>{{ __('Blog List') }}
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label>{{ __('Title') }}</label>
                            <input type="text" name="title" required class="form-control" placeholder="{{ __('Enter Title') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Status') }}</label>
                            <select name="status" required class="form-select">
                                <option value="">{{ __('Select a status') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="img-label">{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="image" class="form-control" required>
                        </div>
                        <div class="col-lg-12 text-center mt-4">
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary m-2">{{__('Cancel')}}</a>
                            <button class="btn btn-primary m-2" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    <script src="{{ asset('assets/js/summernote-lite.js') }}"></script>
@endpush

