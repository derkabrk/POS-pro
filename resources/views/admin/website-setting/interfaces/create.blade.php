@extends('layouts.master')

@section('title')
    {{ __('Create Interfaces') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{  __('Add New Interface') }}</h4>
                        <div>
                            <a href="{{ route('admin.interfaces.index') }}" class="theme-btn print-btn text-light">
                                <i class="fas fa-list me-1"></i>
                                {{ __("View List") }}
                            </a>
                        </div>
                    </div>

                    <div class="order-form-section p-16">
                        <form action="{{ route('admin.interfaces.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf

                            <div class="add-suplier-modal-wrapper">
                                <div class="row">

                                    <div class="col-lg-6 mt-2">
                                        <label class="img-label">{{ __('Image') }}</label>
                                        <input type="file" name="image" required class="form-control">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Status') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="status" required="" class="form-control select-dropdown">
                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0">{{ __('Deactive') }}</option>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="" class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                            <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
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
