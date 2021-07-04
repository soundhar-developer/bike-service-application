<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Mail;

class BookingController extends Controller
{
    /*
    ** Book new service booking with mail notification.
    */
    public function addBooking(Request $request)
    {  
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['service_name'] = json_encode($data['service_name']);
            $addBooking = Booking::create($data);
            if($addBooking) {
                $data = [
                  'subject' => "Regarding bike service.",
                  'email' => Session::get('user')->email,
                  'content' => Session::get('user')->name ." has booked the ". $addBooking->service_name ." service and the service booked on ". $addBooking->booking_date ."."
                ];

                Mail::send('mail.bookedservicemail', $data, function($message) use ($data) {
                    $message->to('soundhars.developer@gmail.com')->subject($data['subject']);
                });
                DB::commit();   
            }
            $response['success'] = true;
            $response['message'] = "Booking has been created successfully";
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }
        return response()->json(['data' => $response]);  
    }

    /*
    ** Fetch all customers current bookings.
    */
    public function customerCurrentBooking() {
        try {
            $bookings = Booking::where('user_id' , Session::get('user')->id)->whereNotIn('status', ['completed'])->get();
            return response()->json(['data' => $bookings]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }
    }

    /*
    ** Fetch all customers previous/completed bookings.
    */
    public function customerPreviousBooking() {
        try {
            $bookings = Booking::where(['user_id' => Session::get('user')->id,'status' => "completed"])->get();
            return response()->json(['data' => $bookings]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }
    }
 

}


?>