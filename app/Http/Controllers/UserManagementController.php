<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $users = User::query()
    //         ->when(!blank($request->search), function ($query) use ($request) {
    //             return $query
    //                 ->where('name', 'like', '%' . $request->search . '%')
    //                 ->orWhere('email', 'like', '%' . $request->search . '%');
    //         })
    //         ->with('roles', function ($query) {
    //             return $query->select('name');
    //         })
    //         ->latest()
    //         ->paginate(10);
    //     $roles = Role::orderBy('name')->get();

    //     return view('user.index', compact('users', 'roles'));
    // }

    public function index(Request $request)
    {
        // $users = User::query()
        //     ->when(!blank($request->search), function ($query) use ($request) {
        //         return $query
        //             ->where('name', 'like', '%' . $request->search . '%')
        //             ->orWhere('email', 'like', '%' . $request->search . '%');
        //     })
        //     // ->with('userSiakad',function($query){
        //     //     return $query->select('username','name');
        //     // })
        //     ->with('roles', function ($query) {
        //         return $query->select('name');
        //     })
        //     ->latest()
        //     ->paginate(10);
        if($request->ajax()){
            $users = User::query()
            ->where('name', 'like', '%' .request('search')['value']  . '%')
            ->orWhere('username', 'like', '%' . request('search')['value'] . '%')
            ->orWhere('email', 'like', '%' . request('search')['value'] . '%')
            ->with('roles', function ($query) {
                return $query->select('name');
            });

            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('roles', function($data){
                $roles = '';
                foreach ($data->roles as $role){
                    $roles .= $role->name.',';
                }
                return $roles;
            })
            ->addColumn('aksi',function ($data){
                $html = '<span class="btn btn-info btn-sm mb-2" wire:click="show(&#39;'.$data->username.'&#39;)">Edit</span><br>';
                    // if (auth()->user()->hasRole(1)){
                    //     $html .= 
                    //     '<form action="'.route("loginAs").'" class="mb-2" method="POST">
                    //         <input type="hidden" name="_token" value="'.csrf_token().'">
                    //         <input type="hidden" name="user_login_as" value="'.$data->username .'">
                    //         <input type="hidden" name="user_request_login_as"
                    //             value="'.auth()->user()->username.'">
                    //         <button class="btn btn-primary btn-sm" type="submit">LoginAs</button>
                    //     </form>';
                    // }                                  
                return $html;
            })
            ->rawColumns(['aksi','usertype','roles'])
            ->make(true);
        }
        return view('user.index',['title'=>'User Management']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserService $userService)
    {
        return $userService->create($request)
            ? back()->with('success', 'User has been created successfully!')
            : back()->with('failed', 'User was not created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('user.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('user.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        return $userService->update($request, $user)
            ? back()->with('success', 'User has been updated successfully!')
            : back()->with('failed', 'User was not updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return $user->delete()
            ? back()->with('success', 'User has been deleted successfully!')
            : back()->with('failed', 'User was not deleted successfully!');
    }
}