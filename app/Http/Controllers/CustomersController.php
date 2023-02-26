<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Validator;
use Response;
use Illuminate\Validation\Rule;

class CustomersController extends Controller {
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $per_page = 5;
        $customers = Customer::orderBy('id', 'desc')
                    ->select('first_name', 'last_name', 'email', 'mobile_number', 'gender', 'id')
                    ->latest()
                    ->paginate($per_page);
        return view('customers.index', compact('customers'));
    }

    public function create() {
        $genders = $this->load_gender();
        $address_types = $this->load_address_types();
        return view('customers.create', compact('genders', 'address_types'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'first_name' => ['required','max:20','regex:"^[a-zA-Z0-9 \s]*$"'],
             'last_name' => ['required','max:20','regex:"^[a-zA-Z0-9 \s]*$"'],
             'gender' => 'required',
             'mobile_number' => 'required|max:10|regex:"^[0-9\s]*$"|unique:customers,mobile_number',
             'email' => 'required|max:30|email|unique:customers,email',
        ]);
        $requestData = $request->all();

        $customers = Customer::create($requestData);
        if($customers ==  true) {
            $address_types = (isset($request->address_type) && !empty($request->address_type)) ? $request->address_type :'';
            $address = (isset($request->address) && !empty($request->address)) ? $request->address :'';
            $city = (isset($request->city) && !empty($request->city)) ? $request->city :'';
            $state = (isset($request->state) && !empty($request->state)) ? $request->state :'';
            $pin_code = (isset($request->pin_code) && !empty($request->pin_code)) ? $request->pin_code :'';
            $is_primary = (isset($request->is_primary) && !empty($request->is_primary)) ? $request->is_primary :'';
            
            foreach($address_types as $key=>$item) {
                $datas = array(
                    'customer' => $customers->id,
                    'address_type' => $item,
                    'address' => (isset($address[$key]) && !empty($address[$key])) ? $address[$key] : NULL,
                    'city' => (isset($city[$key]) && !empty($city[$key])) ? $city[$key] : NULL,
                    'state' => (isset($state[$key]) && !empty($state[$key])) ? $state[$key] : NULL,
                    'pincode' => (isset($pin_code[$key]) && !empty($pin_code[$key])) ? $pin_code[$key] : NULL,
                    'is_primary' => 'no'
                );
                if($is_primary == $key) {
                    $datas['is_primary'] = 'yes';
                }
                CustomerAddress::create($datas);
            }
        }
        return redirect('customers')->with('flash_message', 'Customer Added SuccessFully...!');
    }

    public function edit($id) {
      
        $customers = Customer::select('id','first_name','last_name','email','mobile_number','gender')->findOrFail($id);
        $customer_addresses = CustomerAddress::select('customer','address_type','city','state','pincode','is_primary', 'id', 'address')
                                ->where('customer', $id)
                                ->get();
        $genders = $this->load_gender();
        $address_types = $this->load_address_types();
        return view('customers.edit', compact('genders', 'address_types', 'customer_addresses', 'customers'));
    }

    public function update(Request $request, $id) {
         $this->validate($request, [
            'first_name' => ['required','max:20','regex:"^[a-zA-Z0-9 \s]*$"'],
             'last_name' => ['required','max:20','regex:"^[a-zA-Z0-9 \s]*$"'],
             'gender' => 'required',
             'mobile_number' => ['required', 'max:10','regex:"^[0-9\s]*$"',Rule::unique('customers')->ignore($id)],
            'email' => ['required', 'max:30','email',Rule::unique('customers')->ignore($id)],
        ]);
        $requestData = $request->all();

        $customers = Customer::find($id)->update($requestData);
        if($customers ==  true) {
            $delete_customers = CustomerAddress::where('customer', $id)->delete();
            $address_types = (isset($request->address_type) && !empty($request->address_type)) ? $request->address_type :'';
            $address = (isset($request->address) && !empty($request->address)) ? $request->address :'';
            $city = (isset($request->city) && !empty($request->city)) ? $request->city :'';
            $state = (isset($request->state) && !empty($request->state)) ? $request->state :'';
            $pin_code = (isset($request->pin_code) && !empty($request->pin_code)) ? $request->pin_code :'';
            $is_primary = (isset($request->is_primary) && !empty($request->is_primary)) ? $request->is_primary :'';
            
            foreach($address_types as $key=>$item) {
                $datas = array(
                    'customer' => $id,
                    'address_type' => $item,
                    'address' => (isset($address[$key]) && !empty($address[$key])) ? $address[$key] : NULL,
                    'city' => (isset($city[$key]) && !empty($city[$key])) ? $city[$key] : NULL,
                    'state' => (isset($state[$key]) && !empty($state[$key])) ? $state[$key] : NULL,
                    'pincode' => (isset($pin_code[$key]) && !empty($pin_code[$key])) ? $pin_code[$key] : NULL,
                    'is_primary' => 'no'
                );
                if($is_primary == $key) {
                    $datas['is_primary'] = 'yes';
                }
                CustomerAddress::create($datas);
            }
        }
        return redirect('customers')->with('flash_message', 'Customer Updated SuccessFully!');
    }

    public function destroy($id) {
        if(!empty($id)) {
            Customer::destroy($id);
            CustomerAddress::where('customer', $id)->delete();
            return redirect('customers')->with('flash_message', 'Customer Deleted SuccessFully!');
        }
    }

    function load_gender() {
        return array('' => 'Select Gender', 'male' => 'Male', 'female' => 'FeMale');
    }

    function load_address_types() {
        return array('billing' => 'Billing Address', 'shipping' => 'Shipping Address');
    }

    function load_address() {
           $address_types = $this->load_address_types();
        return view('customers.load_address', compact('address_types'));
    }
    
    public function validate_customers_form(Request $request) {
        $validation_error = array();
        $id = isset($request->id) ? $request->id : '';
         $rules = [
             'first_name' => ['required','max:20','regex:"^[a-zA-Z0-9 \s]*$"'],
             'last_name' => ['required','max:20','regex:"^[a-zA-Z0-9 \s]*$"'],
             'gender' => 'required',
             'mobile_number' => ['required', 'max:10','regex:"^[0-9\s]*$"',Rule::unique('customers')->ignore($id)],
            'email' => ['required', 'max:30','email',Rule::unique('customers')->ignore($id)],
         ];

        $address_types = (isset($request->address_type) && !empty($request->address_type)) ? $request->address_type :'';
        $address = (isset($request->address) && !empty($request->address)) ? $request->address :'';
        $city = (isset($request->city) && !empty($request->city)) ? $request->city :'';
        $state = (isset($request->state) && !empty($request->state)) ? $request->state :'';
        $pin_code = (isset($request->pin_code) && !empty($request->pin_code)) ? $request->pin_code :'';
        $is_primary = (isset($request->is_primary) && $request->is_primary != "") ? $request->is_primary :'';
        if($is_primary == "") {
            $validation_error['primary_0'] = array('The primary field is required');
        }
        foreach($address_types as $key => $item) {
            if(empty($item)) {
                 $validation_error['address_type_'.$key] = array('The address type field is required');
            }
            if(empty($address[$key])) {
                $validation_error['address_'.$key] = array('The address field is required');
            }
            if(empty($city[$key])) {
                $validation_error['city_'.$key] = array('The city field is required');
            }
            if(empty($state[$key])) {
                $validation_error['state_'.$key] = array('The state field is required');
            }
          
            if(empty($pin_code[$key])) {
                $validation_error['pin_code_'.$key] = array('The pincode field is required');
            }
            if(!empty($pin_code[$key]) && strlen($pin_code[$key]) < 6) {
                $validation_error['pin_code_'.$key] = array('Kindly Enter valid pincode');
            }
        }
         $validator = Validator::make($request->all(), $rules); if ($validator->fails() || count($validation_error) > 0) {
         $validation = $validator->getMessageBag()->toArray();
         $error_messages = array_merge($validation_error, $validation);
         return response()->json(['code' => 401, 'errors' => $error_messages]);
         }
         return Response::json(['success' => true], 200);
    }
    
}
