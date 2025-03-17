@foreach ($currencies as $currency)
    <tr>
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $currency->id }}" data-url="{{ route('admin.currencies.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
            <i></i>
        </td>

        <td>{{ $loop->iteration }} <i class="{{ request('id') == $currency->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $currency->name }}</td>
        <td>{{ $currency->code }}</td>
        <td>{{ $currency->rate }}</td>
        <td>{{ $currency->symbol }}</td>
        <td>
            <div class="{{ $currency->status == 1 ? 'badge bg-success' : 'badge bg-danger' }}">
                {{ $currency->status == 1 ? 'Active' : 'Inactive' }}
            </div>
        </td>
        <td>
            <div class="{{ $currency->is_default == 1 ? 'badge bg-success' : 'badge bg-danger' }}">
                {{ $currency->is_default == 1 ? 'Yes' : 'No' }}
            </div>
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">

                    @if ($currency->is_default)
                        @can('currencies-update')
                            <li>
                                <a href="{{ route('admin.currencies.edit', $currency->id) }}">
                                    <i class="fal fa-pencil-alt"></i>
                                    {{ __('Edit') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.currencies.default', ['id' => $currency->id]) }}">
                                    <i class="fas fa-adjust"></i>
                                    {{ __('Make Default') }}
                                </a>
                            </li>
                        @endcan
                    @else
                        @can('currencies-update')
                            <li>
                                <a href="{{ route('admin.currencies.edit', $currency->id) }}">
                                    <i class="fal fa-pencil-alt"></i>
                                    {{ __('Edit') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.currencies.default', ['id' => $currency->id]) }}">
                                    <i class="fas fa-adjust"></i>
                                    {{ __('Make Default') }}
                                </a>
                            </li>
                        @endcan

                        @can('currencies-delete')
                            <li>
                                <a href="{{ route('admin.currencies.destroy', $currency->id) }}" class="confirm-action"
                                    data-method="DELETE">
                                    <i class="fal fa-trash-alt"></i>
                                    {{ __('Delete') }}
                                </a>
                            </li>
                        @endcan
                    @endif
                </ul>
            </div>
        </td>
    </tr>
@endforeach
