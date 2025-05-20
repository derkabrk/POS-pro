@foreach ($banners as $banner)
    <tr class="align-middle">
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $banner->id }}" data-url="{{ route('admin.banners.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $banners->perPage() * ($banners->currentPage() - 1) + $loop->iteration }}</td>
        <td>
            <img class="table-img rounded" height="35" src="{{ asset($banner->imageUrl ?? '') }}" alt="imageUrl">
        </td>
        <td class="text-center">
            @can('banners-update')
                <button type="button" class="btn btn-sm btn-icon btn-light status" data-url="{{ route('admin.banners.status', $banner->id) }}" title="{{ $banner->status == 1 ? 'Deactivate' : 'Activate' }}">
                    <span class="badge bg-{{ $banner->status == 1 ? 'success' : 'danger' }} px-2 py-1">{{ $banner->status == 1 ? 'Active' : 'Deactive' }}</span>
                </button>
            @else
                <span class="badge bg-{{ $banner->status == 1 ? 'success' : 'danger' }} px-2 py-1">
                    {{ $banner->status == 1 ? 'Active' : 'Deactive' }}
                </span>
            @endcan
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('banners-update')
                        <li>
                            <a href="#edit-banner-modal" class="dropdown-item edit-banner-btn" data-bs-toggle="modal" data-url="{{ route('admin.banners.update', $banner->id) }}" data-image="{{ asset($banner->imageUrl) }}" data-status="{{ $banner->status }}">
                                <i class="fal fa-edit me-1"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('banners-delete')
                        <li>
                            <a href="{{ route('admin.banners.destroy', $banner->id) }}" class="dropdown-item confirm-action" data-method="DELETE">
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
