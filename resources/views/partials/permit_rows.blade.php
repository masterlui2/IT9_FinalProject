<tr>
    <td>1</td>
    <td>PERMIT-{{ str_pad($permit->id, 6, '0', STR_PAD_LEFT) }}</td>
    <td>{{ ucfirst($permit->type) }}</td>
    <td>{{ $permit->full_name }}</td>
    <td>{{ $permit->created_at->format('Y-m-d') }}</td>
    <td><span class="badge bg-warning">Pending</span></td>
    <td>
        <button class="btn btn-sm btn-outline-primary">View</button>
    </td>
</tr>