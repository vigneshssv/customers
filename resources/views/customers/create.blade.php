@extends('layouts.admin')

@section('content')
{!! Form::open(['url' => '/customers', 'class' => 'form-horizontal', 'files' => true, 'autocomplete' => 'off', 'class' => 'customers_form']) !!}
 @include ('customers.form', ['formMode' => 'create']) 
 {!! Form::close() !!}
@endsection