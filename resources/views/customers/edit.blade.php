@extends('layouts.admin')

@section('content')

{!! Form::model($customers, [
 'method' => 'PATCH',
 'url' => ['/customers', $customers->id],
 'class' => 'form-horizontal',
 'files' => true, 'autocomplete' => 'off', 'class' => 'customers_form'
 ]) !!}


 @include ('customers.form', ['formMode' => 'edit']) 
 {!! Form::close() !!}
@endsection