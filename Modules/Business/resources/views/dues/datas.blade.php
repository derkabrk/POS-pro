@foreach($dues as $due)
    <tr>
        <td>{{ ($dues->currentPage() - 1) * $dues->perPage() + $loop->iteration }}</td>
        <td>{{ $due->name }}</td>
        <td>{{ $due->email }}</td>
        <td>{{ $due->phone }}</td>
        <td>{{ $due->type }}</td>
        <td class="text-danger">{{ currency_format($due->due, 'icon', 2, business_currency()) }}</td>
        <td>
            <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('business.collect.dues', $due->id) }}" class="dropdown-item">
                            <i class="ri-edit-2-fill align-bottom me-2"></i>{{ __('Collect Due') }}
                        </a>
                    </li>
                    @if($due->dueCollect)
                        <li>
                            <a href="{{ route('business.collect.dues.invoice', $due->id) }}" target="_blank" class="dropdown-item">
                                <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="" class="me-2" style="max-width: 16px; max-height: 16px;">
                                {{ __('Invoice') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </td>
    </tr>
@endforeach
