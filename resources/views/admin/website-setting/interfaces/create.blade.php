@extends('layouts.master')

@section('title')
    {{ __('Create Interfaces') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('Add New Interface') }}</h4>
                <a href="{{ route('admin.interfaces.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-list me-1"></i>{{ __('View List') }}
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.interfaces.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="img-label">{{ __('Image') }}</label>
                            <input type="file" name="image" required class="form-control">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Status') }}</label>
                            <select name="status" required class="form-select">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>
                        </div>
                        <div class="col-lg-12 text-center mt-4">
                            <a href="{{ route('admin.interfaces.index') }}" class="btn btn-outline-secondary m-2">{{__('Cancel')}}</a>
                            <button class="btn btn-primary m-2" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
