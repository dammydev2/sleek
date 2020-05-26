@foreach($data as $row)
<tr>
       <td>{{ $row->id}}</td>
       <td>{{ $row->code }}</td>
       <td>{{ $row->description }}</td>
      </tr>
      @endforeach
      <tr>
       <td colspan="3" align="center">
        {!! $data->links() !!}
       </td>
      </tr>