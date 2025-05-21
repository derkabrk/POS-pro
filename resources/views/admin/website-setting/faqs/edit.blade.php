@extends('layouts.master')

@section('title')
    {{ __('Edit Faqs') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('Edit FAQs') }}</h4>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-list me-1"></i>{{ __('View List') }}
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.faqs.update',['faq'=>$faq]) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Question') }}</label>
                            <input type="text" name="question" value="{{ $faq->question }}" class="form-control">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label>{{ __('Status') }}</label>
                            <select name="status" required class="form-select">
                                <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>{{ __('InActive') }}</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>{{ __('Answer') }}</label>
                            <textarea name="answer" class="form-control">{{ $faq->answer }}</textarea>
                        </div>
                        <div class="col-lg-12 text-center mt-4">
                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary m-2">{{__('Cancel')}}</a>
                            <button class="btn btn-primary m-2" type="submit">{{__('Update')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
