<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {  
        $this ->middleware('auth', [
            'except' => ['show', 'create', 'edit', 'index']
        ]);
    }
    
    public function index()
    {
        $users = User::paginate(15);
        
        return view('user.index', compact('users'));
    }
    
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function create()
    {
    	return view('user.create');
    }
    
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        return view('user.edit', compact('user'));
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        
        $user= User::create([
            'name'     => $request ->name,
            'email'    => $request ->email,
            'password' => bcrypt($request->password),
        ]);
        
        Auth::login($user);
        
        session() ->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        
        return redirect() ->route('users.show', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        
        $user->update($data);
        
        session() ->flash('success', '个人信息修改成功');

        return redirect()->route('users.show', compact('user'));
    }
    
    public function destroy(User $user)
    {
        $user ->delete();
        
        session() ->flash('success', '用户删除成功!!');
        
        return redirect() ->back();
    }
}
