@extends('layouts.master')

@section('title')
    {{ __('Edit Interface') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('Edit Interface') }}</h4>
                <a href="{{ route('admin.interfaces.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-list me-1"></i>{{ __('View List') }}
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.interfaces.update', $interface->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Status') }}</label>
                            <select name="status" required class="form-select">
                                <option @selected($interface->status == 1) value="1">{{ __('Active') }}</option>
                                <option @selected($interface->status == 0) value="0">{{ __('Deactive') }}</option>
                            </select>
                        </div>
                        <div class="col-lg-4 mb-3 align-self-center">
                            <label class="img-label">{{ __('Image') }}</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-lg-2 mb-3 align-self-center mt-4">
                            <img class="table-img" src="{{ asset($interface->image) }}" alt="img">
                        </div>
                        <div class="col-lg-12 text-center mt-4">
                            <a href="{{ route('admin.interfaces.index') }}" class="btn btn-outline-secondary m-2">{{__('Cancel')}}</a>
                            <button class="btn btn-primary m-2" type="submit">{{__('Update')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
