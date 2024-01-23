<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    public $modulename = "Client";
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $client = Client::query();

            return DataTables::eloquent($client)
                ->addColumn('action', function ($client) {

                    $editUrl = url('/client/edit', encrypt($client->id));
                    $viewUrl = url('/client/show', encrypt($client->id));
                    $deleteUrl = url('/client/delete', encrypt($client->id));

                    $actions = '';
                    //edit client
                    if (auth()->user()->hasPermission('edit.client')) {
                        $actions .= "<a href='" . $editUrl . "' class='btn btn-primary btn-sm m-1 text-decoration-none '><i class='fas fa-pencil-alt'></i> Edit</a>";
                    }
                    //edit client
                    if (auth()->user()->hasPermission('view.client')) {
                        $actions .= "<a href='" . $viewUrl . "' class='btn btn-success btn-sm m-1 text-decoration-none '><i class='fas fa-eye'></i> View</a>";
                    }
                    //edit client
                    if (auth()->user()->hasPermission('delete.client')) {
                        $actions .= "<a href='" . $deleteUrl . "' class='btn btn-danger btn-sm m-1 text-decoration-none  delete' id='delete' data-id='" . $client->id . "'><i class='fa-regular fa-trash-can'></i> Delete</a>";
                    }

                    return $actions;
                })
                ->addColumn('logo', function ($client) {
                    return '<img src="' . asset('public/storage/clientlogo/' . $client->logo) . '" class="m-2" style="height: 100px;width: 100px;">';
                })
                ->rawColumns(['action', 'logo'])
                ->addIndexColumn()
                ->make(true);
        }
        $modulename = $this->modulename;
        return view('admin.Client.index', compact('modulename'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $modulename = $this->modulename;
        return view('admin.Client.form', compact('modulename'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //image
        if ($request->hasFile('logo')) {
            $imageName = $request->file('logo');
            $image = rand(10000, 99999) . '.' . $imageName->getClientOriginalExtension();
            $imageName->move('public/storage/clientlogo/', $image);
        }

        //user insert
        $user = new User;
        $user->name = $request->name;
        $user->mobile_no = $request->mobile_no;
        $user->password = Hash::make($request->password);
        $user->expiry_date = $request->expiry_date;
        $user->added_by = auth()->user()->id;
        $user->save();
        $user->attachRole('3');

        //client insert
        $client = new Client;
        $client->user_id = $user->id;
        $client->client_id = "sm_" . $request->client_id;
        $client->name = $request->name;
        $client->mobile_no = $request->mobile_no;
        $client->logo = $image;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->expiry_date = $request->expiry_date;
        $client->number_of_users = $request->number_of_users;
        $client->login_type = $request->login_type;
        $client->added_by = auth()->user()->id;
        $client->save();

        $user->client_id = $client->id;
        $user->save();

        //redirect
        return redirect('/client')->with('success', 'Client added successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $modulename = $this->modulename;
        $data = Client::where('id', decrypt($id))->first();
        return view('admin.Client.view', compact('modulename', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $modulename = $this->modulename;
        $data = Client::where('id', decrypt($id))->first();
        return view('admin.Client._form', compact('modulename', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $client = Client::where('id', decrypt($id))->first();
        if ($request->hasFile('logo')) {
            $image = rand(10000, 99999) . "." . $request->file('logo')->getClientOriginalExtension();
            $imagepath = $request->file('logo')->move('public/storage/clientlogo', $image);
            if (File::exists('public/storage/clientlogo/' . $client->logo)) {
                File::delete('public/storage/clientlogo/' . $client->logo);
            }
        } else {
            $image = $client->logo;
        }

        //user update
        $user = User::where('client_id', $client->id)->first();
        $user->name = $request->name;
        $user->mobile_no = $request->mobile_no;
        $user->expiry_date = $request->expiry_date;
        $user->updated_by = auth()->user()->id;
        $user->save();

        //user password update
        if (!empty($request->password)) {
            User::where('client_id', $client->id)->update(['password' => Hash::make($request->password)]);
        }

        //client update
        $client->name = $request->name;
        $client->mobile_no = $request->mobile_no;
        $client->logo = $image;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->expiry_date = $request->expiry_date;
        $client->number_of_users = $request->number_of_users;
        $client->login_type = $request->login_type;
        $client->updated_by = auth()->user()->id;
        $client->save();

        //redirect
        return redirect('/client')->with('success', 'Client updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $client = Client::where('id', $id)->first();
        $user = User::where('client_id', $client->id)->first();
        $client->delete();
        $user->delete();
        return response()->json(['status' => true]);
    }

    public function checkclient_idExists(Request $request)
    {
        $client_id = $request->client_id;
        $exists = Client::where('client_id', $client_id)->withTrashed()->exists();
        if ($exists) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function checkMobileExists(Request $request)
    {
        $mobileNumber = $request->mobile_no;
        $exists = User::where('mobile_no', $mobileNumber)->withTrashed()->exists();
        if ($exists) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function checkemailExists(Request $request)
    {
        $email = $request->email;
        $exists = Client::where('email', $email)->withTrashed()->exists();
        if ($exists) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function editcheckMobileExists(Request $request)
    {
        $id = $request->user_id;
        $mobileNumber = $request->mobile_no;
        $exists = User::where('mobile_no', $mobileNumber)->where('id', '!=', $id)->withTrashed()->doesntExist();
        return response()->json($exists);
    }

    public function editcheckemailExists(Request $request)
    {
        $id = $request->user_id;
        $email = $request->email;
        $exists = Client::where('email', $email)->where('user_id', '!=', $id)->withTrashed()->doesntExist();
        return response()->json($exists);
    }
}
