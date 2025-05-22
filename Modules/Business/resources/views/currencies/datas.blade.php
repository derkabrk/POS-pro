@foreach ($currencies as $currency)
    <tr>
        <td>{{ ($currencies->currentPage() - 1) * $currencies->perPage() + $loop->iteration }}</td>
        <td>{{ $currency->name }}</td>
        <td>{{ $currency->country_name }}</td>
        <td>{{ $currency->code }}</td>
        <td>{{ $currency->symbol }}</td>
        <td>
            <span class="badge {{ ($user_currency && $currency->name == $user_currency->name) || (!$user_currency && $currency->is_default == 1) ? 'bg-success' : 'bg-secondary' }}">
                {{ ($user_currency && $currency->name == $user_currency->name) || (!$user_currency && $currency->is_default == 1) ? 'Yes' : 'No' }}
            </span>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-2-fill"></i>
                </button>
                @if(!$user_currency || $user_currency->name != $currency->name)
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('business.currencies.default', ['id' => $currency->id]) }}" class="dropdown-item">
                            <i class="fas fa-adjust align-bottom me-2"></i>{{ __('Make Default') }}
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </td>
    </tr>
@endforeach
