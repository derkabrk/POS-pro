@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
<div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
    @include('business::print.header')
    <h4 class="mt-2">{{ __('Customer Due List') }}</h4>
</div>
@endsection

@section('pdf_content')
    <table class="styled-table">
        <thead>
            <tr>
                <th>{{ __('SL') }}.</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Due Amount') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($due_lists as $due_list)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $due_list->name }}</td>
                    <td>{{ $due_list->email }}</td>
                    <td>{{ $due_list->phone }}</td>
                    <td>{{ $due_list->type }}</td>
                    <td>{{ currency_format($due_list->due, 'icon', 2, business_currency()) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
