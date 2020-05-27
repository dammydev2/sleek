@foreach($data as $row)
<tr>
    <td>{{ $row->id}}</td>
    <td>{{ $row->code }}</td>
    <td>{{ $row->cost_price }}</td>
    <td>{{ $row->description }}</td>
    <td>
        @if($row->current_stock < 11) <span class="text-danger">{{ $row->current_stock }}</span>
            @else
            {{ $row->current_stock }}
            @endif
    </td>
    <td><a href="{{ url('addStockItem/'.$row->id) }}" class="btn btn-primary">Add Stock <i class="fa fa-plus-circle"></i></a></td>
    <td><a href="{{ url('deleteItem/'.$row->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure? once deleted, information cannot be retrieved')"><i class="fa fa-trash"></i></a></td>
</tr>
@endforeach
<tr>
    <td colspan="5" align="center">
        {!! $data->links() !!}
    </td>
</tr>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">