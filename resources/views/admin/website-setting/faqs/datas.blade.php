@foreach ($faqs as $faq )
<tr>
    @can('faqs-delete')
        <td class="checkbox text-start">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $faq->id }}" data-url="{{ route('admin.faqs.delete-all') }}">
        </td>
    @endcan
    <td>{{ $loop->index + 1 }}</td>
    <td>{{ $faq->question }}</td>
    <td class="text-center w-150">
        <label class="switch">
            <input type="checkbox" {{ $faq->status == 1 ? 'checked' : '' }} class="status"
                data-url="{{ route('admin.faqs.status', $faq->id) }}">
            <span class="slider round"></span>
        </label>
    </td>
    <td class="print-d-none">
        <div class="dropdown table-action">
            <button type="button" data-bs-toggle="dropdown">
                <i class="far fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#view-single-details" class="view-btn faq-btn" data-question="{{ $faq->question }}" data-answer="{{ $faq->answer }}" data-status="{{ $faq->status == 0 ? __('Active') : __('InActive') }}" data-bs-toggle="modal" data-bs-target="#view-single-details">
                        <i class="fal fa-eye"></i>
                        {{ __('View') }}
                    </a>
                </li>
                @can('faqs-update')
                <li>
                    <a href="{{ route('admin.faqs.edit',$faq->id) }}">
                        <i class="fal fa-pencil-alt"></i>
                        {{ __('Edit') }}
                    </a>
                </li>
                @endcan
                @can('faqs-delete')
                <li>
                    <a href="{{ route('admin.faqs.destroy', $faq->id) }}" class="confirm-action" data-method="DELETE">
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


