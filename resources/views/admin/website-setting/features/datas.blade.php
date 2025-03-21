@foreach ($features as $feature)
    <tr>
        @can('features-delete')
            <td class="w-60 checkbox">
                <label class="table-custom-checkbox">
                    <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item"
                        value="{{ $feature->id }}" data-url="{{ route('admin.features.delete-all') }}">
                    <span class="table-custom-checkmark custom-checkmark"></span>
                </label>
            </td>
        @endcan
        <td>{{ $loop->index + 1 }}</td>
        <td>
            <img class="table-img" src="{{ asset($feature->image) }}" alt="img">
        </td>
        <td>{{ $feature->title }}</td>
        <td class="text-center w-150">
            @can('features-update')
                <label class="switch">
                    <input type="checkbox" {{ $feature->status == 1 ? 'checked' : '' }} class="status"
                        data-url="{{ route('admin.features.status', $feature->id) }}">
                    <span class="slider round"></span>
                </label>
            @endcan
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('features-update')
                        <li>
                            <a href="{{ route('admin.features.edit', $feature->id) }}">
                                <i class="fal fa-pencil-alt"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('features-delete')
                        <li>
                            <a href="{{ route('admin.features.destroy', $feature->id) }}" class="confirm-action"
                                data-method="DELETE">
                                <i class="fal fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </td>
    </tr>
@endforeach
