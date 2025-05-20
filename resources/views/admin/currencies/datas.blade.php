@foreach ($currencies as $currency)
    <tr class="align-middle">
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $currency->id }}" data-url="{{ route('admin.currencies.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $currency->name }}</td>
        <td>{{ $currency->code }}</td>
        <td>{{ $currency->rate }}</td>
        <td>{{ $currency->symbol }}</td>
        <td class="text-center">
            <span class="badge bg-{{ $currency->status == 1 ? 'success' : 'danger' }} px-2 py-1">
                {{ $currency->status == 1 ? 'Active' : 'Inactive' }}
            </span>
        </td>
        <td class="text-center">
            <span class="badge bg-{{ $currency->is_default == 1 ? 'success' : 'danger' }} px-2 py-1">
                {{ $currency->is_default == 1 ? 'Yes' : 'No' }}
            </span>
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('currencies-update')
                        <li>
                            <a href="{{ route('admin.currencies.edit', $currency->id) }}" class="dropdown-item">
                                <i class="fal fa-pencil-alt me-1"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.currencies.default', ['id' => $currency->id]) }}" class="dropdown-item">
                                <i class="fas fa-adjust me-1"></i>
                                {{ __('Make Default') }}
                            </a>
                        </li>
                    @endcan
                    @can('currencies-delete')
                        @if (!$currency->is_default)
                        <li>
                            <a href="{{ route('admin.currencies.destroy', $currency->id) }}" class="dropdown-item confirm-action" data-method="DELETE">
                                <i class="fal fa-trash-alt me-1"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                        @endif
                    @endcan
                </ul>
            </div>
        </td>
    </tr>
@endforeach
