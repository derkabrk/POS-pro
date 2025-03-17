@extends('layouts.master')

@section('title')
    {{ __('Privacy & Policy Settings') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-bodys">
                    <div class="privacy-condition-header p-16">
                        <h4>{{ __('Privacy & Policy Settings') }}</h4>
                    </div>
                    <div class="order-form-section p-16">
                        <form action="{{ route('admin.privacy-policy.store') }}" method="post" enctype="multipart/form-data"
                            class="ajaxform">
                            @csrf
                            <div class="add-suplier-modal-wrapper d-block">
                                <div class="row">

                                    <div class="form-group">
                                        <label>{{ __('Title') }}</label>
                                        <input type="text" name="privacy_title"
                                            value="{{ $privacy_policy->value['privacy_title'] ?? '' }}"
                                            placeholder="{{ __('Enter Title') }}" required class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Description One') }}</label>
                                        <textarea name="description_one" class="form-control" required rows="3" placeholder="{{ __('Enter Description') }}">{{ $privacy_policy->value['description_one'] ?? '' }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Description Two') }}</label>
                                        <textarea name="description_two" class="form-control" required rows="3" placeholder="{{ __('Enter Description') }}">{{ $privacy_policy->value['description_two'] ?? '' }}</textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="text-center mt-5">
                                            <button type="submit" class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
