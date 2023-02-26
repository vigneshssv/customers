@extends('layouts.admin')

@section('content')
<div class="row pb-2">
	<div class="col-md-12 p-0">
		<a href="{{ url('/customers/create') }}" class="btn btn-sm btn-success float-right" title="Add new Customer"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add</a>
	</div>
</div>

<div class="row">
 <table class="table table-bordered">
    <thead>
      <tr>
      	<th class="text-center">#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Mobile Number</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($customers as $item)
      <tr>
        <td>{{ (($customers->currentPage() - 1) * $customers->perPage()) + $loop->iteration }}</td>
        <td>{{ (isset($item->first_name) && !empty($item->first_name)) ? $item->first_name : '-' }}</td>
        <td>{{ (isset($item->last_name) && !empty($item->last_name)) ? $item->last_name : '-' }}</td>
        <td>{{ (isset($item->mobile_number) && !empty($item->mobile_number)) ? $item->mobile_number : '-' }}</td>
        <td>{{ (isset($item->email) && !empty($item->email)) ? $item->email : '-' }}</td>
        <td>
        	<a href="{{ url('/customers/'.$item->id.'/edit') }}" title="Edit Customer"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        	<form method="POST" action="{{ url('/customers' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}<button type="submit" class="btn btn-xs icon_red" title="Delete Customer" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash align-top" aria-hidden="true"></i></button>
			</form>
        </td>
      </tr>
     	@empty
     	<tr>
     		<td colspan="6" class="text-center"><b>No Data Found</b></td>
     	</tr>
     	@endforelse
    </tbody>
  </table>
<div class="d-flex justify-content-center">
    {!! $customers->links() !!}
</div>
</div>
@endsection
