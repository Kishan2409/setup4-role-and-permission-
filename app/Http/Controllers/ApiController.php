<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //
    public function checkclient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
        ], [
            'client_id.required' => 'Client id is required.',
        ]);

        if ($validator->fails()) {
            //validation error
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ]);
        } else {
            //today date
            $today = now()->format('Y-m-d');
            //check client
            $client = Client::whereRaw('BINARY client_id = ?', $request->client_id)->first();
            //when client not found
            if ($client == null) {
                return response()->json([
                    "success" => 0,
                    "message" => "Client not found.",
                    "is_valid" => 0,
                    "client" => $client
                ]);
            }
            //check client expiry date
            if ($client->expiry_date >= $today || $client->expiry_date == null) {
                $responce = [];
                $responce['id'] = $client->id;
                $responce['user_id'] = $client->user_id;
                $responce['client_id'] = $client->client_id;
                $responce['name'] = $client->name;
                $responce['mobile_no'] = $client->mobile_no;
                $responce['logo'] = url('public/storage/clientlogo/' . $client->logo);
                $responce['email'] = $client->email;
                $responce['address'] = $client->address;
                $responce['expiry_date'] = $client->expiry_date;
                $responce['number_of_users'] = $client->number_of_users;
                $responce['login_type'] = $client->login_type;
                $responce['added_by'] = $client->added_by;
                $responce['updated_by'] = $client->updated_by;
                $responce['deleted_at'] = $client->deleted_at;
                $responce['created_at'] = $client->created_at;
                $responce['updated_at'] = $client->updated_at;

                return response()->json([
                    "success" => 1,
                    "message" => "success",
                    "is_valid" => 1,
                    "client" => $responce
                ]);
            } else {
                //client plan expire
                return response()->json([
                    'success' => 0,
                    'message' => 'Your plan is expired Please contact the admin.',
                ]);
            }
        }
    }

    public function userlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'mobile_no' => 'required|digits:10',
            'password' => 'required'

        ], [
            'client_id.required' => 'Client id is required.',
            'mobile_no.required' => 'Mobile Number is required.',
            'mobile_no.digits' => 'Mobile Number must be 10 digits.',
            'password.required' => 'Password is required.',
        ]);

        if ($validator->fails()) {
            //validation error
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ]);
        } else {
            //check for login
            $checkdata = User::where('mobile_no', $request->mobile_no)->where('added_by', $request->client_id)->first();

            if ($checkdata == null) {

                //user not found
                return response()->json([
                    'success' => 0,
                    'message' => 'User not found.',
                ]);
            } else {

                //today date
                $today = now()->format('Y-m-d');

                //check user expiry date
                if ($checkdata->expiry_date >= $today || $checkdata->expiry_date == null) {

                    $credentials = $request->only('mobile_no', 'password');

                    //check credentials
                    if (Auth::attempt($credentials)) {

                        $user = Auth::user();

                        $client = Client::where('user_id', $user->added_by)->first();

                        $responce = [];
                        $responce['id'] = $user->id;
                        $responce['client_id'] = $user->client_id;
                        $responce['name'] = $user->name;
                        $responce['mobile_no'] = $user->mobile_no;
                        $responce['email_verified_at'] = $user->email_verified_at;
                        $responce['expiry_date'] = $user->expiry_date;
                        $responce['added_by'] = $user->added_by;
                        $responce['updated_by'] = $user->updated_by;
                        $responce['deleted_at'] = $user->deleted_at;
                        $responce['created_at'] = $user->created_at;
                        $responce['updated_at'] = $user->updated_at;

                        if (Auth::check() && $client->login_type == 1) {
                            $user->tokens()->delete();
                        }

                        //generate token
                        $responce['token'] = $user->createToken('MyApp')->accessToken;

                        return response()->json([
                            "success" => 1,
                            "message" => "success",
                            "user" => $responce,
                        ]);
                    }

                    //user not found
                    if (!Auth::attempt($credentials)) {
                        return response()->json([
                            'success' => 0,
                            'message' => 'User not found.',
                        ]);
                    }
                } else {

                    //client plan expire
                    return response()->json([
                        'success' => 0,
                        'message' => 'Your plan is expired Please contact the admin.',
                    ]);
                }
            }
        }
    }

    public function dashboard()
    {
        $user = Auth::guard('api')->user();
        $today = now()->format('Y-m-d');

        if ($user->expiry_date >= $today || $user->expiry_date == null) {

            return response()->json([
                "success" => 1,
                "message" => "success",
                "client" =>  $user,
            ]);
        } else {
            $user->tokens()->delete();
            return response()->json([
                'success' => 0,
                'message' => 'Your plan is expired Please contact the admin.',
            ]);
        }
    }
}
