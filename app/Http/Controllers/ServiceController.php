<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\Service;
use App\Models\Booking;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Mail;

class ServiceController extends Controller
{
    /*
    ** Create new service.
    */
    public function addService(Request $request)
    {  
        DB::beginTransaction();
        try {
            $data = $request->all();
            $addService = Service::create($data);
            $response['success'] = true;
            $response['message'] = "Service has been created successfully";
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
    ** update existing service.
    */
    public function editService(Request $request)
    {  
        DB::beginTransaction();
        try {
            $service = Service::find($request->get('id'));
            $service->fill($request->all());
            $service->save();        
            $response['success'] = true;
            $response['message'] = "Service has been updated successfully";
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
    ** Fetch all services.
    */
    public function loadAllServices() {
        try {
            $services = Service::all();
            return response()->json(['data' => $services]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }
    }

    /*
    ** fetch particular services based on service id.
    */
    public function getService($serviceId) {
        try {
            $services = Service::find($serviceId);
            return response()->json(['data' => $services]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }
    }

    /*
    ** delete existing service.
    */
    public function deleteService(Request $request) {
        DB::beginTransaction();
        try {
            $service = Service::find($request->get('id'));
            if($service) {
                $service->delete();
                $response['success'] = true;
                $response['message'] = "Service has been deleted successfully";
            } else {
                $response['success'] = false;
                $response['message'] = "This data is not available.";
            }
            DB::commit();
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }

        return response()->json(['data' => $response]);
    }


    /*
    ** Fetch all pending bookings.
    */
    public function loadPendingBooking() {
        try {
            $bookings = Booking::where('status', "pending")->with('user')->get();
            return response()->json(['data' => $bookings]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
            return response()->json(['data' => $response]);
        }
    }

    /*
    ** Fetch all bookings to ready for delivery.
    */
    public function loadReadyForDeliveryBooking() {
        try {
            $bookings = Booking::where('status', "ready-for-delivery")->with('user')->get();
            return response()->json(['data' => $bookings]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
            return response()->json(['data' => $response]);
        }
    }

    /*
    ** Fetch all previous/completed bookings.
    */
    public function loadPreviousBooking() {
        try {
            $bookings = Booking::where('status', "completed")->with('user')->get();
            return response()->json(['data' => $bookings]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
            return response()->json(['data' => $response]);
        }
    }

    /*
    ** Update booking/delivery with sending mail to customer based on status.
    */
    public function updateBookingStatus(Request $request) {
        DB::beginTransaction();
        try {
            $booking = Booking::find($request->get('id'));
            $booking->fill($request->all());
            $booking->save();    
            if($request->get('status') == "ready-for-delivery") {
                $user = User::find($booking->user_id);
                $data = [
                  'subject' => "Regarding bike service delivery.",
                  'email' => $user->email,
                  'content' => $user->name ." has booked the service and the service booked on ". $booking->booking_date ." and its ready for delivery."
                ];

                Mail::send('mail.bookedservicemail', $data, function($message) use ($data) {
                    $message->to($data['email'])->subject($data['subject']);
                });
                $response['success'] = true;
                $response['message'] = "Service has been completed and ready for delivery.";
            } else {
                $response['success'] = true;
                $response['message'] = "Bike has been delivered successfully.";
            } 
            DB::commit(); 
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }
        return response()->json(['data' => $response]);
    }

     

}


?>