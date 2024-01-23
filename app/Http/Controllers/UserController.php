<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public $modulename = "User";
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //ajax call for data table
        if ($request->ajax()) {

            //superadmin
            if (auth()->user()->hasRole('superadmin')) {

                $user = User::with(['roles'])->select('users.*');

                return DataTables::eloquent($user)
                    ->addColumn('action', function ($user) {

                        $editUrl = url('/user/edit', encrypt($user->id));
                        $viewUrl = url('/user/show', encrypt($user->id));
                        $deleteUrl = url('/user/delete', encrypt($user->id));

                        $actions = '';

                        $userRoles = $user->roles->pluck('name')->toArray();

                        if (in_array('Super admin', $userRoles)) {
                            $actions = '';
                        } else {
                            //edit permission
                            if (auth()->user()->hasPermission('edit.user')) {
                                $actions .= "<a href='" . $editUrl . "' class='btn btn-primary btn-sm m-1 text-decoration-none '><i class='fas fa-pencil-alt'></i> Edit</a>";
                            }
                            //view permission
                            if (auth()->user()->hasPermission('view.user')) {
                                $actions .= "<a href='" . $viewUrl . "' class='btn btn-success btn-sm m-1 text-decoration-none '><i class='fas fa-eye'></i> View</a>";
                            }
                            //delete permission
                            if (auth()->user()->hasPermission('delete.user')) {
                                $actions .= "<a href='" . $deleteUrl . "' class='btn btn-danger btn-sm m-1 text-decoration-none  delete' id='delete' data-id='" . $user->id . "'><i class='fa-regular fa-trash-can'></i> Delete</a>";
                            }
                        }

                        return $actions;
                    })
                    ->addColumn('userrole', function ($user) {
                        $rolename = $user->roles->pluck('name')->implode(', ');
                        return "<center>
                        <span class='badge rounded-pill bg-dark'>" .  $rolename . "</span>
                        </center>";
                    })
                    ->editColumn('added_by', function ($user) {
                        return $user->addedBy->name;
                    })
                    ->filter(function ($data) use ($request) {
                        $roles = $request->get('roles');
                        if ($roles == '1' || $roles == '2' || $roles == '3') {
                            $data->whereHas('roles', function ($roledata) use ($roles) {
                                $roledata->where('roles.id', $roles);
                            });
                        }
                        if (!empty($request->get('search'))) {
                            $data->where(function ($wordsearch) use ($request) {
                                $search = $request->get('search');
                                $wordsearch->orWhere('client_id', 'LIKE', "%$search%")
                                    ->orWhere('name', 'LIKE', "%$search%")
                                    ->orWhere('mobile_no', 'LIKE', "%$search%")
                                    ->orWhere('expiry_date', 'LIKE', "%$search%");
                                $wordsearch->orWhereHas('addedBy', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%$search%");
                                });
                            });
                        }
                    })
                    ->rawColumns(['action', 'userrole'])
                    ->addIndexColumn()
                    ->make(true);
            }

            //client
            if (auth()->user()->hasRole('client')) {

                $userId = auth()->user()->id;

                // $users = User::with(['roles', 'clients'])
                //     ->where('added_by', $userId)
                //     ->orWhereHas('clients', function ($query) use ($userId) {
                //         $query->where('user_id', $userId);
                //     })
                //     ->select('users.*');

                $users = User::with(['roles'])
                    ->where('added_by', $userId)
                    ->select('users.*');

                return DataTables::of($users)
                    ->addColumn('action', function ($user) {
                        $editUrl = url('/user/edit', encrypt($user->id));
                        $viewUrl = url('/user/show', encrypt($user->id));
                        $deleteUrl = url('/user/delete', encrypt($user->id));

                        $actions = '';

                        // Edit permission
                        if (auth()->user()->hasPermission('edit.user')) {
                            $actions .= "<a href='" . $editUrl . "' class='btn btn-primary btn-sm m-1 text-decoration-none'><i class='fas fa-pencil-alt'></i> Edit</a>";
                        }
                        // View permission
                        if (auth()->user()->hasPermission('view.user')) {
                            $actions .= "<a href='" . $viewUrl . "' class='btn btn-success btn-sm m-1 text-decoration-none'><i class='fas fa-eye'></i> View</a>";
                        }
                        // Delete permission
                        if (auth()->user()->hasPermission('delete.user')) {
                            $actions .= "<a href='" . $deleteUrl . "' class='btn btn-danger btn-sm m-1 text-decoration-none delete' id='delete' data-id='" . $user->id . "'><i class='fa-regular fa-trash-can'></i> Delete</a>";
                        }

                        return $actions;
                    })
                    ->addColumn('userrole', function ($user) {
                        $rolename = $user->roles->pluck('name')->implode(', ');
                        return "<center><span class='badge rounded-pill bg-dark'>" .  $rolename . "</span></center>";
                    })
                    ->editColumn('added_by', function ($user) {
                        return $user->addedBy->name;
                    })
                    ->filter(function ($data) use ($request) {
                        if (!empty($request->get('search'))) {
                            $data->where(function ($wordsearch) use ($request) {
                                $search = $request->get('search');
                                $wordsearch->orWhere('client_id', 'LIKE', "%$search%")
                                    ->orWhere('name', 'LIKE', "%$search%")
                                    ->orWhere('mobile_no', 'LIKE', "%$search%")
                                    ->orWhere('expiry_date', 'LIKE', "%$search%")
                                    ->orWhere('added_by', 'LIKE', "%$search%");
                                $wordsearch->orWhereHas('addedBy', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%$search%");
                                });
                            });
                        }
                    })
                    ->rawColumns(['action', 'userrole'])
                    ->addIndexColumn()
                    ->make(true);
            }

            //user
            if (auth()->user()->hasRole('user')) {
                $userId = auth()->user()->id;

                $users = User::with(['roles'])->where('id', $userId)->select('users.*');

                return DataTables::of($users)
                    ->addColumn('action', function ($user) {
                        $editUrl = url('/user/edit', encrypt($user->id));
                        $viewUrl = url('/user/show', encrypt($user->id));
                        $deleteUrl = url('/user/delete', encrypt($user->id));

                        $actions = '';

                        // Edit permission
                        if (auth()->user()->hasPermission('edit.user')) {
                            $actions .= "<a href='" . $editUrl . "' class='btn btn-primary btn-sm m-1 text-decoration-none'><i class='fas fa-pencil-alt'></i> Edit</a>";
                        }
                        // View permission
                        if (auth()->user()->hasPermission('view.user')) {
                            $actions .= "<a href='" . $viewUrl . "' class='btn btn-success btn-sm m-1 text-decoration-none'><i class='fas fa-eye'></i> View</a>";
                        }
                        // Delete permission
                        if (auth()->user()->hasPermission('delete.user')) {
                            $actions .= "<a href='" . $deleteUrl . "' class='btn btn-danger btn-sm m-1 text-decoration-none delete' id='delete' data-id='" . $user->id . "'><i class='fa-regular fa-trash-can'></i> Delete</a>";
                        }

                        return $actions;
                    })
                    ->addColumn('userrole', function ($user) {
                        $rolename = $user->roles->pluck('name')->implode(', ');
                        return "<center><span class='badge rounded-pill bg-dark'>" .  $rolename . "</span></center>";
                    })
                    ->editColumn('added_by', function ($user) {
                        return $user->addedBy->name;
                    })
                    ->filter(function ($data) use ($request) {
                        if (!empty($request->get('search'))) {
                            $data->where(function ($wordsearch) use ($request) {
                                $search = $request->get('search');
                                $wordsearch->orWhere('client_id', 'LIKE', "%$search%")
                                    ->orWhere('name', 'LIKE', "%$search%")
                                    ->orWhere('mobile_no', 'LIKE', "%$search%")
                                    ->orWhere('expiry_date', 'LIKE', "%$search%");
                                $wordsearch->orWhereHas('addedBy', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%$search%");
                                });
                            });
                        }
                    })
                    ->rawColumns(['action', 'userrole'])
                    ->addIndexColumn()
                    ->make(true);
            }
        }
        $modulename = $this->modulename;
        return view('admin.User.index', compact('modulename'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $modulename = $this->modulename;
        $roles = Role::all();
        $permissions = Permission::get()->groupBy('model');
        return view('admin.User.form', compact('modulename', 'roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //client
        if (auth()->user()->hasRole('client')) {
            $id = Auth::user()->id;
            $client = Client::where('user_id', $id)->first();
            $countuser = User::where('added_by', $id)->count();
            $number_of_users = $client->number_of_users;

            if ($number_of_users > $countuser) {
                //create user
                $user = new User;
                $user->name = $request->name;
                $user->mobile_no = $request->mobile_no;
                $user->password = Hash::make($request->password);
                $user->expiry_date = $request->expiry_date;
                $user->added_by = auth()->user()->id;

                //permissions
                $permission = $request->permission;

                $user->save();
                //attachRole
                $user->attachRole($request->role);
                //attachPermission
                $user->attachPermission($permission);
                //redirect
                return redirect('/user')->with('success', 'User added successfully !');
            } else {
                return redirect('/user')->with('error', 'User creating limits is over, your limit is ' . $countuser . '/' . $client->number_of_users . ' please contact admin!');
            }
        }

        //superadmin
        if (auth()->user()->hasRole('superadmin')) {
            //create user
            $user = new User;
            $user->name = $request->name;
            $user->mobile_no = $request->mobile_no;
            $user->password = Hash::make($request->password);
            $user->expiry_date = $request->expiry_date;
            $user->added_by = auth()->user()->id;

            //permissions
            $permission = $request->permission;

            $user->save();
            //attachRole
            $user->attachRole($request->role);
            //attachPermission
            $user->attachPermission($permission);
            //redirect
            return redirect('/user')->with('success', 'User added successfully !');
        }

        //user
        if (auth()->user()->hasRole('user')) {
            $countuser = 1;
            $number_of_users = 0;

            if ($number_of_users > $countuser) {
                //create user
                $user = new User;
                $user->name = $request->name;
                $user->mobile_no = $request->mobile_no;
                $user->password = Hash::make($request->password);
                $user->expiry_date = $request->expiry_date;
                $user->added_by = auth()->user()->id;

                //permissions
                $permission = $request->permission;

                $user->save();
                //attachRole
                $user->attachRole($request->role);
                //attachPermission
                $user->attachPermission($permission);
                //redirect
                return redirect('/user')->with('success', 'User added successfully !');
            } else {
                return redirect('/user')->with('error', 'Your role is user you can not crate user!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $modulename = $this->modulename;
        $data = User::where('id', decrypt($id))->first();
        $roles = Role::all();
        $permissions = Permission::get()->groupBy('model');
        $approved = PermissionUser::where('user_id', decrypt($id))->pluck('permission_id')->toArray();
        return view('admin.User.view', compact('modulename', 'data', 'roles', 'permissions', 'approved'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $modulename = $this->modulename;
        $data = User::where('id', decrypt($id))->first();
        $roles = Role::all();
        $permissions = Permission::get()->groupBy('model');
        $approved = PermissionUser::where('user_id', decrypt($id))->pluck('permission_id')->toArray();
        return view('admin.User._form', compact('modulename', 'data', 'roles', 'permissions', 'approved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::where('id', decrypt($id))->first();

        //user update
        $user->name = $request->name;
        $user->mobile_no = $request->mobile_no;
        $user->client_id = isset($request->client_id) ? $request->client_id : null;
        $user->expiry_date = $request->expiry_date;
        $user->updated_by = auth()->user()->id;
        $permission = $request->permission;
        // $user->syncRoles($request->role);
        $user->syncPermissions($permission);
        $user->save();

        //user password update
        if (!empty($request->password)) {
            User::where('id', decrypt($id))->update(['password' => Hash::make($request->password)]);
        }

        if ($user->client_id != null) {
            //client update
            $client = Client::where('id', $user->client_id)->first();
            $client->name = $request->name;
            $client->mobile_no = $request->mobile_no;
            $client->expiry_date = $request->expiry_date;
            $client->updated_by = auth()->user()->id;
            $client->save();
        }

        //redirect
        return redirect('/user')->with('success', 'User updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;

        $user = User::where('id',  $id)->first();

        if ($user->client_id != null) {
            $client = Client::where('id', $user->client_id)->first();
            $client->delete();
        }

        $user->delete();

        return response()->json(['status' => true]);
    }
}
