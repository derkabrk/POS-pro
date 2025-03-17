@foreach (Module::all() as $module)
    <tr>
        @php
            $name = $module->getName();
        @endphp
        <td>{{ $loop->iteration }}</td>
        <td class="text-center">{{ $name }}</td>
        <td class="text-center">{{ $module->get('version') }}</td>
        <td class="text-center">
            <label class="switch">
                <input type="checkbox" {{ $module->isEnabled() ? 'checked' : '' }} class="status" data-method="GET" data-url="{{ route('admin.addons.show', $name) }}">
                <span class="slider round"></span>
            </label>
        </td>
    </tr>
@endforeach
