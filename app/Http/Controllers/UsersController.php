<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Mail;
use App\Notifications\ResetPassword;

class UsersController extends Controller
{
    public function __construct()
    {  
        $this ->middleware('auth', [
            'except' => ['show', 'create', 'edit', 'index', 'store', 'confirmEmail']
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
    }
    
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@yousails.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
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
    
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
