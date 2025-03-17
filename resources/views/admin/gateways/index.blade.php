@extends('layouts.master')

@section('title')
    {{ __('Gateway Settings') }}
@endsection

@section('main_content')
    <div class="erp-table-section system-settings">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-bodys mb-4">
                    <div class="tab-content order-summary-tab mt-0">
                        <div class="tab-pane fade active show" id="add-new-petty" role="tabpanel">

                            <div class="table-header">
                                <div class="card-bodys">
                                    <div class="table-header border-0 p-16">
                                        <h4>{{ __('Payment Gateway Settings') }}</h4>
                                    </div>
                                </div>
                            </div> <br>

                            <div class="row">
                                <div class="col-sm-11">
                                    <div class="order-form-section p-16">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-4 mb-4">
                                                <ul class="nav nav-pills flex-column flex-column shadow w-280 p-2">
                                                    @foreach ($gateways as $gateway)
                                                        <li class="nav-item">
                                                            <a href="#{{ str_replace(' ', '-', $gateway->name) }}" id="{{ str_replace(' ', '-', $gateway->name) }}-tab4"
                                                                @class([
                                                                    'add-report-btn nav-link',
                                                                    'active' => $loop->first ? true : false,
                                                                ])
                                                                data-bs-toggle="tab">
                                                                {{ $gateway->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-8">
                                                <div class="cards border-0 shadow">
                                                    <div class="card-body">
                                                        <div class="tab-content no-padding">
                                                            @foreach ($gateways as $gateway)
                                                                <div @class([
                                                                    'tab-pane fade',
                                                                    'show active' => $loop->first ? true : false,
                                                                ])
                                                                    id="{{ str_replace(' ', '-', $gateway->name) }}">
                                                                    <form action="{{ route('admin.gateways.update', $gateway->id) }}" method="post" class="ajaxform">
                                                                        @csrf
                                                                        @method('put')

                                                                        <div class="row">
                                                                            <div class="col-11 align-self-center mb-2">
                                                                                <label class="img-label">{{ __('GATEWAY IMAGE') }}</label>
                                                                                <input type="file" name="image" class="form-control">
                                                                            </div>

                                                                            <div class="col-1 align-self-center mb-2">
                                                                                <img src="{{ asset($gateway->image) }}" class="img-fluid" alt="">
                                                                            </div>

                                                                            <div class="col-12 mb-2">
                                                                                <label>{{ __('GATEWAY NAME') }}</label>
                                                                                <input type="text" name="name" value="{{ $gateway->name }}" required class="form-control">
                                                                            </div>

                                                                            <div class="col-12 mb-2">
                                                                                <label>{{ __('Gateway Charge') }}</label>
                                                                                <input type="number" step="any" name="charge" value="{{ $gateway->charge }}" value="{{ $gateway->charge }}" class="form-control">
                                                                            </div>

                                                                            <div class="col-12 mb-2">
                                                                                <label>{{ __('Gateway Currency') }}</label>
                                                                                <div class="gpt-up-down-arrow position-relative">
                                                                                <select class="form-control" required
                                                                                    name="currency_id">
                                                                                    @foreach ($currencies as $currency)
                                                                                        <option @selected($gateway->currency_id == $currency->id) value="{{ $currency->id }}">
                                                                                            {{ $currency->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span></span>
                                                                                </div>
                                                                            </div>

                                                                            @if (!$gateway->is_manual)
                                                                                @foreach ($gateway->data as $key => $data)
                                                                                    <div class="col-12 mb-2">
                                                                                        <label>{{ strtoupper(str_replace('_', ' ', $key)) }}</label>
                                                                                        <input type="text" name="data[{{ $key }}]" value="{{ $data }}" required class="form-control">
                                                                                    </div>
                                                                                @endforeach

                                                                                <div class="col-12 mb-2">
                                                                                    <label>{{ __('Gateway Mode') }}</label>
                                                                                    <div class="gpt-up-down-arrow position-relative">
                                                                                        <select class="form-control" required name="mode">
                                                                                            <option @selected($gateway->mode == 'Sandbox') value="Sandbox">
                                                                                                {{ __('Sandbox') }}
                                                                                            </option>
                                                                                            <option @selected($gateway->mode == 'Live') value="Live">
                                                                                                {{ __('Live') }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <span></span>
                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                            <div class="col-12 mb-2">
                                                                                <label>{{ __('Status') }}</label>
                                                                                <div class="gpt-up-down-arrow position-relative">
                                                                                <select class="form-control" required name="status">
                                                                                    <option @selected($gateway->status == 1) value="1">{{ __('Active') }}</option>
                                                                                    <option @selected($gateway->status == 0) value="0">{{ __('Deactive') }}</option>
                                                                                </select>
                                                                                <span></span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12 mb-2">
                                                                                <label>{{ __('Is Manual') }}</label>
                                                                                <div class="gpt-up-down-arrow position-relative">
                                                                                <select class="form-control" required
                                                                                    name="is_manual">
                                                                                    <option @selected($gateway->is_manual == 1) value="1">{{ __('Yes') }}</option>
                                                                                    <option @selected($gateway->is_manual == 0) value="0">{{ __('No') }}</option>
                                                                                </select>
                                                                                <span></span>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="col-12 mb-2 {{ $gateway->is_manual ? '' : 'd-none' }}">
                                                                                <label>{{ __('Accept Image') }}</label>
                                                                                <div class="gpt-up-down-arrow position-relative">
                                                                                <select class="form-control" required
                                                                                    name="accept_img">
                                                                                    <option @selected($gateway->accept_img == 1)
                                                                                        value="1">{{ __('Yes') }}
                                                                                    </option>
                                                                                    <option @selected($gateway->accept_img == 0)
                                                                                        value="0">{{ __('No') }}
                                                                                    </option>
                                                                                </select>
                                                                                <span></span>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="col-12 mb-2 {{ $gateway->is_manual ? '' : 'd-none' }}">
                                                                                <div class="manual-rows">
                                                                                    @foreach ($gateway->manual_data['label'] ?? [] as $key => $row)
                                                                                        <div class="row row-items">
                                                                                            <div class="col-sm-5">
                                                                                                <label for="">{{ __('Label') }}</label>
                                                                                                <input type="text" name="manual_data[label][]" value="{{ $row }}" class="form-control" required placeholder="{{ __('Enter label name') }}">
                                                                                            </div>
                                                                                            <div class="col-sm-5">
                                                                                                <label for="">{{ __('Select Required/Optionl') }}</label>
                                                                                                <div class="gpt-up-down-arrow position-relative">
                                                                                                    <select class="form-control"
                                                                                                        required
                                                                                                        name="manual_data[is_required][]">
                                                                                                        <option
                                                                                                            @selected($gateway->manual_data['is_required'][$key] == 1)
                                                                                                            value="1">
                                                                                                            {{ __('Required') }}
                                                                                                        </option>
                                                                                                        <option
                                                                                                            @selected($gateway->manual_data['is_required'][$key] == 0)
                                                                                                            value="0">
                                                                                                            {{ __('Optional') }}
                                                                                                        </option>
                                                                                                    </select>
                                                                                                    <span></span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-2 align-self-center mt-3">
                                                                                                <button type="button" class="btn text-danger trash remove-btn-features">
                                                                                                    <i class="fas fa-trash"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12 mt-2">
                                                                                        <a href="javascript:void(0)" class="fw-bold primary add-new-item">
                                                                                            <i class="fas fa-plus-circle"></i>
                                                                                            {{ __('Add new row') }}
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12 mb-2">
                                                                                <label for="instructions">{{ __('INSTRUCTIONS') }}</label>
                                                                                <textarea name="instructions" id="instructions" class="form-control summernote" placeholder="{{ __('Enter payment instructions here') }}">{{ $gateway->instructions }}</textarea>
                                                                            </div>

                                                                            <div class="col-lg-12">
                                                                                <div class="button-group text-center mt-4">
                                                                                    <button class="theme-btn m-2 submit-btn">
                                                                                        <i class="far fa-save me-1"></i>
                                                                                        {{ __('Save') }}
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/summernote-lite.js') }}"></script>
    <script>
        $('.summernote').summernote({
            height: 150,
        });

        $('.ajaxform_instant_reload').on('submit', function() {
            $('.summernote').each(function() {
                $(this).val($(this).summernote('code'));
            });
        });
    </script>
@endpush
