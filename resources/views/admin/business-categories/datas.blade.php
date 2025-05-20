@foreach($categories as $category)
    <tr class="align-middle">
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" class="table-hidden-checkbox checkbox-item" name="ids[]" value="{{ $category->id }}" data-url="{{ route('admin.business-categories.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $loop->iteration }}</td>
        <td class="text-start">{{ $category->name }}</td>
        <td class="text-start">{{ $category->description }}</td>
        <td class="text-center">
            @can('business-categories-update')
                <button type="button" class="btn btn-sm btn-icon btn-light status" data-url="{{ route('admin.business-categories.status', $category->id) }}" title="{{ $category->status == 1 ? 'Deactivate' : 'Activate' }}">
                    <span class="badge bg-{{ $category->status == 1 ? 'success' : 'danger' }} px-2 py-1">{{ $category->status == 1 ? 'Active' : 'Deactive' }}</span>
                </button>
            @else
                <span class="badge bg-{{ $category->status == 1 ? 'success' : 'danger' }} px-2 py-1">
                    {{ $category->status == 1 ? 'Active' : 'Deactive' }}
                </span>
            @endcan
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('business-categories-update')
                        <li><a href="{{ route('admin.business-categories.edit', $category->id) }}" class="dropdown-item"><i class="fal fa-pencil-alt me-1"></i>{{__('Edit')}}</a></li>
                    @endcan
                    @can('business-categories-delete')
                        <li>
                            <a href="{{ route('admin.business-categories.destroy', $category->id) }}" class="dropdown-item confirm-action" data-method="DELETE">
                                <i class="fal fa-trash-alt me-1"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </td>
    </tr>
@endforeach
