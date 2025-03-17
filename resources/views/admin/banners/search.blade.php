@foreach ($banners as $banner)
    <tr>
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item"
                    value="{{ $banner->id }}" data-url="{{ route('admin.banners.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>

        <td>{{ $banners->perPage() * ($banners->currentPage() - 1) + $loop->iteration }}</td>
        <td>
            <img class="table-img" height="35px" src="{{ asset($banner->imageUrl ?? '') }}" alt="imageUrl">
        </td>
        <td class="text-center">
            @can('banners-update')
                <label class="switch">
                    <input type="checkbox" {{ $banner->status == 1 ? 'checked' : '' }} class="status"
                        data-url="{{ route('admin.banners.status', $banner->id) }}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $banner->status == 1 ? 'success' : 'danger' }}">
                    {{ $banner->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('banners-update')
                        <li>
                            <a href="#edit-banner-modal" class="edit-banner-btn" data-bs-toggle="modal"
                                data-url="{{ route('admin.banners.update', $banner->id) }}"
                                data-image="{{ asset($banner->imageUrl) }}" data-status="{{ $banner->status }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('banners-delete')
                        <li>
                            <a href="{{ route('admin.banners.destroy', $banner->id) }}" class="confirm-action"
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
