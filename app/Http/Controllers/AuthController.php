<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Session;
 
class AuthController extends Controller
{
    /*
    ** Login user
    */
    public function login(Request $request)
    {
        try {
            request()->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $request->get('email'))->first();
            if (Auth::attempt($credentials)) {
                // Authentication passed...
                Session::put('user', $user);
                $data['success'] = true;
                $data['id'] = $user->id;
                $data['name'] = $user->name;
                $data['user_type'] = $user->user_type;
                $data['mobile'] = $user->mobile;
            } else if ( $user->password != Hash::make($request->get('password')) || $user->email != $request->get('email') ) {
                $data['success'] = false;
                $data['message'] = "Email/password is incorrect.";
            } else {
                $data['success'] = false;
                $data['message'] = "Invalid Email.If you are not register please signup.";
            }
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $data['success'] = false;
            $data['message'] = "Invalid Email.If you are not register please signup.";
        }
        return response()->json(['data' => $data]);
    }
    
    /*
    ** Register new customer
    */
    public function registerCustomer(Request $request)
    {  
        DB::beginTransaction();
        try {
            $response = [];
            $input = $request->all();
            $data = [
                'name' => $input['name'],
                'email' => $input['email'],
                'mobile' => $input['mobile'],
                'user_type' => "customer",
                'password' => Hash::make($input['password'])
              ];
            $customer = User::where('email', $input['email'])->first();
            Log::info(5555);
            Log::info($customer);
            if($customer) {
                $response['success'] = false;
                $response['message'] = "Email address already register.";
            } else {
                $createCustomer = User::create($data);
                $response['success'] = true;
                $response['message'] = "User has been register successfully";
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }
        return response()->json(['data' => $response]);  
    }
     
    /*
    ** Logout user
    */
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
?>