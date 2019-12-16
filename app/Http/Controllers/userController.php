<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Inbox;
use App\Booking;
use Illuminate\Support\Facades\DB;
use Helper;


class userController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['test_helper', 'login', 'searchUser', 'store', 'phoneStore', 'medsos','info', 'inbox']]);;
    }

    protected function authenticated(){
        \Auth::logoutOtherDevices(request('password'));
    }

    public function index(){
        $users = User::where('role','1')->orderBy('created_at', 'DESC')->paginate(10);
        $cashiers = User::where('role','3')->orderBy('created_at', 'DESC')->get();
        $blocks = User::where('role','0')->orderBy('created_at', 'DESC')->get();
        return view('userPage', ['users' => $users, 'cashiers' => $cashiers, 'blocks' => $blocks]);
    }
    public function searchUser(Request $request){
        return User::where('name','LIKE', '%'.$request->name.'%')->where('role', '1')->get();
    }
    public function getDataUser(Request $request){
        if(getRole()===2){
            return User::where('id',$request->id)->where('role','!=','2')->get()->first();
        }
    }

    public function saveUserData(Request $request){
        if(getRole()===2){
            $user = User::select('id','name','email','role','avatar','phone')->where('id', $request->id)->first();
            if(!empty($request->file('avatar'))){
                Storage::delete('img/avatar/'.$user->avatar);
                $file       = $request->file('avatar');
                $fileName   = randomAvatarName(8).".".$file->getClientOriginalExtension();
                $request->file('avatar')->move("img/avatar", $fileName);

                $user->avatar = $fileName;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role = $request->role !== 2 ? $request->role : 0 ;
            $user->save();
            return back();
        }
    }

    public function searchUsers(Request $request){
        if(getRole()===2){
            return User::select('id','name','email','role','avatar','phone')->where('name','LIKE', '%'.$request->name.'%')->where('role','!=', '2')->get();
        }
    }
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->job = $request->job;
        $user->fcm_token = $request->fcm_token;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'user_id' => $user->id,
            'success' => 'true'
        ], 200);
    }

    public function refreshToken(Request $request){
        $user = User::where('id', $request->id)->first();
        $user->fcm_token = $request->fcm_token;
        $user->save();
        return response()->json([
            'success' => 'success'
        ]);
    }

    public function inbox(Request $request){
        $inbox = Inbox::where('user_id', $request->user_id)->orderBy('created_at', 'DESC')->get();
        $result = array();

        foreach($inbox as $data){
            $var['title'] = $data->title;
            $var['content'] = $data->content;
            $result[] = $var;
        }
        return response()->json(
            $result
        , 200);
    }

    public function phoneStore(Request $request)
    {
        $user = User::find($request->id);
        $user->phone = $request->phone;
        $user->save();
        return response()->json([
            'success' => 'true'
        ], 200);
    }
    public function medsos(Request $request)
    {
        $check = User::where('email',$request->email)->where('password',$request->provider)->where('role','!=',0);
        if(count($check) <= 0){
            //belum registrasi
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->avatar = $request->avatar;
            $user->password = $request->provider;
            $user->fcm_token = $request->fcm_token;
            $user->save();
            return response()->json([
                'success' => 'true',
                'user_id' => $user->id,
                'phone' => $user->phone
            ], 200);
        }else{
            //sudah pernah registrasi ke login
            return response()->json([
                'success' => 'true',
                'user_id' => $check->first()->id,
                'phone' => $check->first()->phone
            ], 200);
        }
    }
    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->where('role','!=',0)->first();
        // return $user;
        if(Hash::check($request->password, $user->password))
        {
            $user->fcm_token = $request->fcm_token;
            $user->save();

            return response()->json([
                'success' => 'true',
                'user_id' => $user->id,
                'role' => $user->role
            ], 200);
        }else{
            return response()->json([
                'success' => 'false'
            ], 401);
        }
    }
    public function info(Request $request)
    {
        // DC24
        $id = $request->id;
        if(!isset($id)) return Helper::composeReply('ERROR', 'Harap masukkan ID user');

        $user = User::where('id',$id)->first();
        if(substr($user->avatar, 0, 4)!="http"){
            $avatar = "http://admin.tangriaspa.com/img/avatar/".$user->avatar;
        }else{
            $avatar = $user->avatar;
        }
        // return $user;
        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $avatar,
            'no_hp' => $user->phone,
        ], 200);
    }
    public function block(Request $request)
    {
        $user = User::find($request->id);
        if($user->role != 0 ){
            $user->role = 0;
        }else{
            $user->role = 1;
        }
        if($user->save()){
            return redirect()->back();
        }
    }
    public function update(Request $request)
    {
        $user = User::where('id',$request->id);

        return response()->json([
            'succes' => 'true'
        ], 200);
    }
    public function editWeb(Request $request)
    {
        $user = User::find($request->id);
        return view('userEdit')->with('user',$user);
    }
    public function updateWeb(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if(!empty($request->file('avatar'))){
            Storage::delete('img/avatar/'.$user->avatar);
            $file       = $request->file('avatar');
            $fileName   = randomAvatarName(8).".".$file->getClientOriginalExtension();
            $request->file('avatar')->move("img/avatar", $fileName);

            $user->avatar = $fileName;
        }
        $user->save();
        return redirect()->back();
    }
    public function management(){
        if(getRole()===2){
            $users = User::where('role','!=','2')->orderBy('created_at', 'DESC')->paginate(20);
            // return $users;
            return view('management.listUsers', ['users' => $users]);
        }else{
            return view(auth.login);
        }
    }
    public function ubahPasswordUserView(Request $request){
        if(getRole()===2){
            $user = User::where('id',$request->id)->get()->first();
            if($user->role !== 2){
                return view('management.changePassword', ['user' => $user]);
            }else{
                return redirect('/login');
            }
        }else{
            return redirect('/login');
        }
    }
    public function ubahPasswordUser(Request $request){
        if(getRole()===2){
            $user = User::where('id',$request->id)->get()->first();
            if($user->role !== 2){
                $user->password = bcrypt($request->newPassword);
                $user->save();
                return back()->with('message', 'User: <b><i>'.$user->name.'</i></b><br>password : <b><i>'.$request->newPassword.'</i></b>');
            }else{
                return redirect('/login');
            }
        }else{
            return redirect('/login');
        }
    }
}
