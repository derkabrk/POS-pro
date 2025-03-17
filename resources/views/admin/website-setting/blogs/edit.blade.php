@extends('layouts.master')

@section('title')
    {{ __('Edit Blog') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{ __('Edit Blog') }}</h4>
                        <a href="{{ route('admin.blogs.index') }}" class="theme-btn print-btn text-light">
                            <i class="fas fa-list me-1"></i>
                            {{ __('Blog List') }}
                        </a>
                    </div>
                    <div class="tab-content order-summary-tab p-16 mt-0">
                        <div class="tab-pane fade mt-1 show active" id="add-new-user">
                            <div class="order-form-section">
                                <form action="{{ route('admin.blogs.update',$blog->id) }}" method="post" enctype="multipart/form-data"
                                    class="ajaxform_instant_reload">
                                    @csrf
                                    @method('PUT')

                                    <div class="add-suplier-modal-wrapper">
                                        <div class="row">
                                            <div class="col-lg-12 mt-2">
                                                <label>{{ __('Title') }}</label>
                                                <input type="text" name="title" value="{{ $blog->title }}" required class="form-control"
                                                    placeholder="{{ __('Enter Title') }}">
                                            </div>

                                            <div class="col-lg-6 mt-2">
                                                <label>{{ __('Status') }}</label>
                                                <div class="gpt-up-down-arrow position-relative">
                                                    <select name="status" required=""
                                                        class="form-control select-dropdown">
                                                        <option value="1" @selected($blog->status == 1 ? 'active' : '')>{{__('Active')}}</option>
                                                        <option value="0" @selected($blog->status == 0 ? 'active' : '')>{{__('Deactive')}}</option>
                                                    </select>
                                                    <span></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mt-2">
                                                <label class="img-label">{{ __('Image') }}</label>
                                                <input type="file" name="image" accept="image/*" class="form-control file-input-change" data-id="image">
                                            </div>

                                            <div class="col-lg-1 mt-2 align-self-center">
                                                <div class="align-self-center mt-3">
                                                    <img src="{{ asset($blog->image ?? 'assets/img/demo-img.png') }}" id="image" class="table-img" >
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-2">
                                                <label>{{__('Description')}}</label>
                                                <textarea name="descriptions" class="form-control summernote-blogs" placeholder="{{ __('Enter Description') }}">{!! $blog->descriptions !!}</textarea>
                                            </div>

                                            <div class="col-12 mb-2">
                                                <div class="manual-rows" id="dynamic-input-fields">

                                                    <div class="row single-tags">
                                                        @foreach($blog->tags ?? [] as $tag)
                                                        <div class="col-md-6">
                                                            <div class="row row-items">
                                                                <div class="col-sm-10">
                                                                    <label for="">{{ __('Tags') }}</label>
                                                                    <input type="text" name="tags[]" class="form-control" value="{{ $tag ?? '' }}" required
                                                                        placeholder="{{ __('Enter tags name') }}">
                                                                </div>
                                                                <div class="col-sm-2 align-self-center mt-3">
                                                                    <button type="button" class="btn text-danger trash remove-btn-features"
                                                                        onclick="removeDynamicField(this)"><i
                                                                            class="fas fa-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mt-2">
                                                        <a href="javascript:void(0)" class="fw-bold text-primary add-new-tag"
                                                            onclick="addDynamicField()"><i class="fas fa-plus-circle"></i>{{ __('Add new
                                                            row') }}</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="mt-5">{{ __('SEO Meta Tags') }}</h6>
                                            <div class="col-lg-12 mt-2">
                                                <label>{{__('Meta Title')}}</label>
                                                <input type="text" name="meta[title]" value="{{ $blog->meta['title'] ?? '' }}" class="form-control" placeholder="{{ __('Enter Title') }}">
                                            </div>
                                            <div class="col-lg-12 mt-2">
                                                <label>{{__('Meta Description')}}</label>
                                                <textarea type="text" name="meta[description]"  class="form-control" placeholder="{{ __('Enter meta Description') }}">{{ $blog->meta['description'] ?? '' }} </textarea>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="button-group text-center mt-5">
                                                    <a href=""
                                                        class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                                    <button class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
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
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    <script src="{{ asset('assets/js/summernote-lite.js') }}"></script>
@endpush
