@extends('layouts.master')

@section('title')
    {{ __('Privacy & Policy Settings') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ __('Privacy & Policy Settings') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.privacy-policy.store') }}" method="post" enctype="multipart/form-data" class="ajaxform">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label>{{ __('Title') }}</label>
                            <input type="text" name="privacy_title" value="{{ $privacy_policy->value['privacy_title'] ?? '' }}" placeholder="{{ __('Enter Title') }}" required class="form-control">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>{{ __('Description One') }}</label>
                            <textarea name="description_one" class="form-control" required rows="3" placeholder="{{ __('Enter Description') }}">{{ $privacy_policy->value['description_one'] ?? '' }}</textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>{{ __('Description Two') }}</label>
                            <textarea name="description_two" class="form-control" required rows="3" placeholder="{{ __('Enter Description') }}">{{ $privacy_policy->value['description_two'] ?? '' }}</textarea>
                        </div>
                        <div class="col-lg-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary m-2 submit-btn">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
