/*
resources/views/admin/business/dates.blade.php
*/
@foreach($businesses as $key => $business)
<tr>
    <td>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="business_ids[]" value="{{ $business->id }}">
        </div>
    </td>
    <td>{{ $key + 1 }}</td>
    <td>{{ $business->business_name }}</td>
    <td>{{ $business->category->name ?? '-' }}</td>
    <td>
        @if($business->type === 1)
            {{ __('E-commerce') }}
        @elseif($business->type === 0)
            {{ __('Physical') }}
        @else
            {{ __('Both') }}
        @endif
    </td>
    <td>{{ $business->phone }}</td>
    <td>{{ $business->plan->subscriptionName ?? '-' }}</td>
    <td>{{ optional($business->last_enroll)->format('d M, Y') ?? '-' }}</td>
    <td>{{ optional($business->expired_date)->format('d M, Y') ?? '-' }}</td>
    <td>
        {{-- Actions: edit, delete, view etc. --}}
        <a href="{{ route('admin.business.edit', $business->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
        <form action="{{ route('admin.business.destroy', $business->id) }}" method="POST" style="display:inline-block;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
        </form>
    </td>
</tr>
@endforeach



