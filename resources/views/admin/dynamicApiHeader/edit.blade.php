@extends('layouts.master')

@section('title', 'Edit API Header')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('API Headers') }}
        @endslot
        @slot('title')
            {{ __('Edit API Header') }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit API Header')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.dynamicApiHeader.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i> {{ __('View All API Headers') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dynamicApiHeader.update', $dynamicApiHeader->id) }}" method="POST" class="ajaxform_instant_reload" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="row gy-4">
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $dynamicApiHeader->name }}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="api_key" class="form-label">API Key <span class="text-danger">*</span></label>
                                    <input type="text" name="api_key" id="api_key" class="form-control" value="{{ $dynamicApiHeader->api_key }}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control" data-choices data-choices-sorting-false>
                                        <option value="1" {{ $dynamicApiHeader->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$dynamicApiHeader->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div>
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4">{{ $dynamicApiHeader->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-center mt-4">
                                    <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary" id="editButton">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
