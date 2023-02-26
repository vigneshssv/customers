 <tr>
    <td> {!! Form::select('address_type[]',$address_types ,null, ['class' => 'form-control select2', 'required' => 'required']) !!}
      <span class="address_type help-block"></span>
    </td>
  <td>
    <textarea name="address[]" placeholder="Street Address" class="form-control form-control-sm"  cols="2" rows="2"></textarea>
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
      <input class="form-check-input primary_name" type="radio" name="is_primary" value="" onclick="load_is_primary(this.value)"> Primary
       <span class="primary help-block"></span>
  </td>
</tr>