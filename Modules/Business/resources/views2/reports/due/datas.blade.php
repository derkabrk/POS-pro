@foreach($due_lists as $due_list)
    <tr>
        <td>{{ ($due_lists->currentPage() - 1) * $due_lists->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $due_list->name }}</td>
        <td class="text-start">{{ $due_list->email }}</td>
        <td class="text-start">{{ $due_list->phone }}</td>
        <td class="text-start">{{ $due_list->type }}</td>
        <td class="text-start">{{ currency_format($due_list->due, 'icon', 2, business_currency()) }}</td>
    </tr>
@endforeach
