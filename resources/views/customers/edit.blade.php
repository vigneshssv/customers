@extends('layouts.admin')

@section('content')
<h4>Edit Customer</h4>
{!! Form::model($customers, [
 'method' => 'PATCH',
 'url' => ['/customers', $customers->id],
 'class' => 'form-horizontal',
 'files' => true, 'autocomplete' => 'off', 'class' => 'customers_form'
 ]) !!}


 @include ('customers.form', ['formMode' => 'edit']) 
 {!! Form::close() !!}
@endsection