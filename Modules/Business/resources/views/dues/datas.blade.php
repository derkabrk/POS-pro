@foreach($dues as $due)
    <tr>
        <td>{{ ($dues->currentPage() - 1) * $dues->perPage() + $loop->iteration }}</td>
        <td>{{ $due->name }}</td>
        <td>{{ $due->email }}</td>
        <td>{{ $due->phone }}</td>
        <td>{{ $due->type }}</td>
        <td class="text-danger">{{ currency_format($due->due, 'icon', 2, business_currency()) }}</td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('business.collect.dues', $due->id) }}">
                            <i class="fal fa-edit"></i>
                            {{ __('Collect Due') }}
                        </a>
                    </li>
                    @if($due->dueCollect)
                        <li>
                            <a href="{{ route('business.collect.dues.invoice', $due->id) }}" target="_blank">
                                <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="" >
                                {{ __('Invoice') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </td>
    </tr>
@endforeach
