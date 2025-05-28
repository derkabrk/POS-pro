@foreach($variants as $variant)
<tr>
    <td>{{ $variant->variantName }}</td>
    <td>{{ $variant->variantCode }}</td>
    <td>
        <span class="badge {{ $variant->status ? 'bg-success' : 'bg-danger' }}">
            {{ $variant->status ? __('Active') : __('Inactive') }}
        </span>
    </td>
    <td>
        <a href="{{ route('business.product-variants.edit', $variant->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
        <button data-id="{{ $variant->id }}" class="btn btn-sm btn-danger delete-variant">{{ __('Delete') }}</button>
    </td>
</tr>
@endforeach
