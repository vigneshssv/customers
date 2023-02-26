<div class="row">
  <div class="col-md-3 mb-3">
    <label>First Name<span  style="color:red"> *</span></label>
    {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required','maxlength' => '20', 'placeholder' => 'Enter First Name']) !!}
    {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
    <span class="help-block first_name_error"></span>
    <input type="hidden" name="id" value="{{ !empty($customers->id) ? $customers->id : '' }}">
  </div>
   <div class="col-md-3 mb-3">
    <label>Last Name<span  style="color:red"> *</span></label>
    {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required','maxlength' => '20', 'placeholder' => 'Enter Last Name']) !!}
    {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
     <span class="help-block last_name_error"></span>
  </div>
   <div class="col-md-3 mb-3">
    <label>Gender<span  style="color:red"> *</span></label>
    {!! Form::select('gender',$genders ,null, ['class' => 'form-control select2', 'required' => 'required']) !!}
    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
     <span class="help-block gender_error"></span>
  </div>
   <div class="col-md-3 mb-3">
    <label>Mobile Number<span  style="color:red"> *</span></label>
    {!! Form::text('mobile_number', null, ['class' => 'form-control', 'required' => 'required','maxlength' => '10', 'placeholder' => 'Enter Mobile Number','oninput'=>'onlyNumbersPaste(this)', 'onkeypress' => 'return onlyNumbers(this.value,event)']) !!}
    {!! $errors->first('mobile_number', '<p class="help-block">:message</p>') !!}
     <span class="help-block mobile_number_error"></span>
  </div>
   <div class="col-md-3 mb-3">
    <label>Email<span  style="color:red"> *</span></label>
    {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required','maxlength' => '20', 'placeholder' => 'Enter Email']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    <span class="help-block email_error"></span>

  </div>
</div>
<div class="row">
  <h4>Address</h4>
  <table class="table table-bordered customers_table">
    <tbody class="address_list">
      @if($formMode == "create")
      <tr>
        <td width="15%"> {!! Form::select('address_type[]',$address_types ,null, ['class' => 'form-control select2', 'required' => 'required']) !!}
          <span class="address_type help-block"></span>
        </td>

      <td width="20%">
        <textarea placeholder="Street Address" class="form-control form-control-sm" name="address[]" cols="2" rows="2"></textarea>
        <span class="address help-block"></span>
      </td>
      <td>
        <input type="text" name="city[]" placeholder="Enter City" maxlength="10" class="form-control form-control-sm">
        <span class="city help-block"></span>
      </td>
      <td>
        <input type="text" name="state[]" placeholder="Enter State" maxlength="10" class="form-control form-control-sm">
        <span class="state help-block"></span>
      </td>
       <td>
        <input type="text" name="pin_code[]" placeholder="Enter Pin Code" maxlength="6" class="form-control form-control-sm" oninput='onlyNumbersPaste(this)' onkeypress = 'return onlyNumbers(this.value,event)'>
        <span class="pin_code help-block"></span>
      </td>
      <td>
          <input class="form-check-input primary_name" type="radio" value="0" name="is_primary" onclick="load_is_primary(this.value)"> Primary
          <br>
          <span class="primary help-block"></span>
      </td>
      </tr>
      @else
      @if(!empty($customer_addresses) && !empty($customer_addresses))
      @foreach($customer_addresses as $item)
       <tr>
        <td width="15%"> {!! Form::select('address_type[]',$address_types ,!empty($item->address_type) ? $item->address_type : null, ['class' => 'form-control select2', 'required' => 'required']) !!}
          <span class="address_type help-block"></span>
        </td>
      <td width="20%">
        <textarea placeholder="Street Address" class="form-control form-control-sm" name="address[]" cols="2" rows="2">{{ !empty($item->address) ? $item->address : null }}</textarea>
        <span class="address help-block"></span>
      </td>
      <td>
        <input type="text" name="city[]" placeholder="Enter City" maxlength="10" class="form-control form-control-sm" value="{{ !empty($item->city) ? $item->city : null }}">
        <span class="city help-block"></span>
      </td>
      <td>
        <input type="text" name="state[]" placeholder="Enter State" maxlength="10" class="form-control form-control-sm" value="{{ !empty($item->state) ? $item->state : null }}">
        <span class="state help-block"></span>
      </td>
       <td>
        <input type="text" name="pin_code[]" placeholder="Enter Pin Code" maxlength="6" class="form-control form-control-sm" oninput='onlyNumbersPaste(this)' onkeypress = 'return onlyNumbers(this.value,event)' value="{{ !empty($item->pincode) ? $item->pincode : null }}">
        <span class="pin_code help-block"></span>
      </td>
      <td>
          <input class="form-check-input primary_name" type="radio" value="0" name="is_primary" onclick="load_is_primary(this.value)" <?php echo (!empty($item->is_primary) && $item->is_primary == "yes") ? 'checked' : ''; ?>> Primary
          <br>
          <span class="primary help-block"></span>
      </td>
      </tr>
      @endforeach
      @endif
      @endif
    </tbody>
    <tfoot>
      <td colspan="6"><button class="btn btn-sm btn-primary" type="button" onclick="load_address()"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add More</button></td>
    </tfoot>
  </table>
</div>
<div class="row">
  <div class="col-sm-4 p-0">
   
    <button type="button" class="btn btn-success btn-sm" onclick="validate_form()">Submit</button>
    <a href="{{url('/customers')}}" class="btn btn-danger btn-sm" >Close</a>

  </div>
</div>

<style type="text/css">
  .padding
</style>

