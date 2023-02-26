$( document ).ready(function() {
     $('.select2').select2();
});

function base_url() {
    return $('#base_url').val();
}
function load_address() {
    $.ajax({
     type: "GET",
     url: base_url() + "/load-address",
     contentType: false,
     success: function (data) {
        $('.address_list').append(data);
         $('.select2').select2();
         load_address_errors();
     },
     error: function () {
     alert("SOMETHING WENT WRONG");
     },
    });
}

function validate_form() {
    load_address_errors();
    $.ajax({
         type: 'post',
         url: base_url() + "/validate-customers-form",
         headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data: $(".customers_form").serialize(),
         beforeSend: function () {
             $(".help-block").text("");
         },
         success: function (data) { 
            if ($.isEmptyObject(data.errors)) {
                 $("form.customers_form").submit();
            } else {
                var code = data.code;
                if (code == 401) {
                var errors = data.errors;
                $.each(errors, function (key, val) {

                 $("." + key + "_error").text("*" + val[0]);
                });
                } else {
                 $(".customers_form_error").text(data.errors);
                }
            }
        }
    });
}

function load_address_errors() {
    var i = 0;
    $('.customers_table > tbody  > tr').each(function(index, tr) { 
        var j = i++;
       $(this).find('.address_type').addClass('address_type_'+j+'_error');
       $(this).find('.address').addClass('address_'+j+'_error');
       $(this).find('.city').addClass('city_'+j+'_error');
       $(this).find('.state').addClass('state_'+j+'_error');
       $(this).find('.pin_code').addClass('pin_code_'+j+'_error');
       $(this).find('.primary').addClass('primary_'+j+'_error');
       $(this).find('.primary_name').attr('value', j);
    });
}

function onlyNumbersPaste(input) {
 let value = input.value;
 let numbers = value.replace(/[^0-9]/g, "");
 if (input.value === numbers) {
 input.value = numbers;
 } else {
 input.value = numbers.replace(/[^0-9]/g, '');
 }
}
function onlyNumbers(val, evt) {
 evt = evt ? evt : window.event;
 var charCode = evt.which ? evt.which : evt.keyCode;
 if (charCode < 48 || charCode > 57) {
 return false;
 }
 return true;
}

function load_is_primary(value = "") {
    if(value != "") {
        $('.primary_name').removeAttr('checked');
        $("input[value="+value+"]").attr('checked', true);
    }
}