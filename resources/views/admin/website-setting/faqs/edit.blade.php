@extends('layouts.master')

@section('title')
    {{ __('Edit Faqs') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{__('Edit FAQs') }}</h4>
                        <a href="{{ route('admin.faqs.index') }}" class="theme-btn print-btn text-light">
                            <i class="fas fa-list" aria-hidden="true"></i>
                            {{ __('View List') }}
                        </a>
                    </div>
                    <div class="order-form-section">
                        {{-- form start --}}
                        <form action="{{ route('admin.faqs.update',['faq'=>$faq]) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="add-suplier-modal-wrapper">
                                <div class="row">
                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Question') }}</label>
                                        <input type="text" name="question" value="{{ $faq->question }}" class="form-control">
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label>{{ __('Status') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="status" required="" class="form-control select-dropdown">
                                                <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>{{ __('InActive') }}</option>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Answer') }}</label>
                                        <textarea name="answer" class="form-control">{{ $faq->answer }}</textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="" class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                            <button class="theme-btn m-2 submit-btn">{{__('Update')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- form end --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
