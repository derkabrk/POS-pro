@extends('layouts.master')

@section('title')
    {{ __('Gateway Settings') }}
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ __('Payment Gateway Settings') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <ul class="nav nav-pills flex-column shadow p-2">
                            @foreach ($gateways as $gateway)
                                <li class="nav-item">
                                    <a href="#{{ str_replace(' ', '-', $gateway->name) }}" id="{{ str_replace(' ', '-', $gateway->name) }}-tab4"
                                        @class([
                                            'nav-link',
                                            'active' => $loop->first ? true : false,
                                        ])
                                        data-bs-toggle="tab">
                                        {{ $gateway->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content">
                            @foreach ($gateways as $gateway)
                                <div @class([
                                    'tab-pane fade',
                                    'show active' => $loop->first ? true : false,
                                ])
                                    id="{{ str_replace(' ', '-', $gateway->name) }}">
                                    <form action="{{ route('admin.gateways.update', $gateway->id) }}" method="post" class="ajaxform">
                                        @csrf
                                        @method('put')
                                        <div class="row g-3 align-items-center">
                                            <div class="col-11 mb-2">
                                                <label class="form-label">{{ __('GATEWAY IMAGE') }}</label>
                                                <input type="file" name="image" class="form-control">
                                            </div>
                                            <div class="col-1 mb-2">
                                                <img src="{{ asset($gateway->image) }}" class="img-fluid rounded" alt="">
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label">{{ __('GATEWAY NAME') }}</label>
                                                <input type="text" name="name" value="{{ $gateway->name }}" required class="form-control">
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label">{{ __('Gateway Charge') }}</label>
                                                <input type="number" step="any" name="charge" value="{{ $gateway->charge }}" class="form-control">
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label">{{ __('Gateway Currency') }}</label>
                                                <select class="form-control" required name="currency_id">
                                                    @foreach ($currencies as $currency)
                                                        <option @selected($gateway->currency_id == $currency->id) value="{{ $currency->id }}">
                                                            {{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if (!$gateway->is_manual)
                                                @foreach ($gateway->data as $key => $data)
                                                    <div class="col-12 mb-2">
                                                        <label class="form-label">{{ strtoupper(str_replace('_', ' ', $key)) }}</label>
                                                        <input type="text" name="data[{{ $key }}]" value="{{ $data }}" required class="form-control">
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="col-12 text-end mt-3">
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
