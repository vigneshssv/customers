@extends('layouts.admin')

@section('content')
<h4>Create Customer</h4>
{!! Form::open(['url' => '/customers', 'class' => 'form-horizontal', 'files' => true, 'autocomplete' => 'off', 'class' => 'customers_form']) !!}
 @include ('customers.form', ['formMode' => 'create']) 
 {!! Form::close() !!}
@endsection