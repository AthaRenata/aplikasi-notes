<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index',[
            'users' => $this->service->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validatedData = $request->validate([
                'role'=>'required',
                'name'=>'required',
                'phone'=>'required|unique:users,phone',
                'password'=>'required'
            ]);

        $this->service->saveData($validatedData);

        return redirect('/users')->with('success',"Pengguna <strong>$request->name</strong> berhasil ditambahkan");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit',[
            'user' => $this->service->getById($user->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name'=>'required',
            'phone'=>['required',Rule::unique('users')->ignore($user->id)],
            'password'=>'nullable',
            'role'=>'required',
        ]);

        $validatedData['id'] = $user->id;

        $this->service->updateData($validatedData);

        return redirect('/users')->with('success',"Pengguna <strong>$request->name</strong> berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->service->deleteById($user->id);

        return redirect('/users')->with('success',"Pengguna <strong>$user->phone</strong> berhasil dihapus");
    }

    public function inactiveList()
    {
        return view('admin.users.inactive-user-list',[
            'users' =>  $this->service->getAllInactive(),
        ]);
    }

    public function activateUser(User $user)
    {
        $this->service->updateIsActive($user->id);
        return redirect('/users/activate')->with('success',"Pengguna <strong>$user->name</strong> berhasil diaktifkan");
    }
}
