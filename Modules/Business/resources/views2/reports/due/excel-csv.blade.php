<table>
    <thead>
        <tr>
            <th>{{ __('SL') }}.</th>
            <th class="text-start">{{ __('Name') }}</th>
            <th class="text-start">{{ __('Email') }}</th>
            <th class="text-start">{{ __('Phone') }}</th>
            <th class="text-start">{{ __('Type') }}</th>
            <th class="text-start">{{ __('Due Amount') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($due_lists as $due_list)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td class="text-start">{{ $due_list->name }}</td>
                <td class="text-start">{{ $due_list->email }}</td>
                <td class="text-start">{{ $due_list->phone }}</td>
                <td class="text-start">{{ $due_list->type }}</td>
                <td class="text-start">{{ currency_format($due_list->due, 'icon', 2, business_currency()) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
