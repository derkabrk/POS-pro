@foreach ($testimonials as $testimonial )
<tr>
    @can('testimonials-delete')
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $testimonial->id }}" data-url="{{ route('admin.testimonials.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
            <i ></i>
        </td>
    @endcan
    <td>{{ $loop->index + 1 }}</td>
    <td>
        @for ($i = 0; $i < 5; $i++)
            <i @class(['fas fa-star ', 'text-warning' => $testimonial->star > $i])></i>
        @endfor
    </td>
    <td>{{ $testimonial->client_name }}</td>
    <td>{{ $testimonial->work_at }}</td>
    <td>
        <img class="table-img" src="{{ asset($testimonial->client_image) }}" alt="img">
    </td>
    <td class="print-d-none">
        <div class="dropdown table-action">
            <button type="button" data-bs-toggle="dropdown">
                <i class="far fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('admin.testimonials.edit',$testimonial->id) }}">
                        <i class="fal fa-pencil-alt"></i>
                        {{ __('Edit') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.testimonials.destroy', $testimonial->id) }}" class="confirm-action" data-method="DELETE">
                        <i class="fal fa-trash-alt"></i>
                        {{ __('Delete') }}
                    </a>
                </li>
            </ul>
        </div>
    </td>
</tr>
@endforeach
