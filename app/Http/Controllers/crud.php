<?php

namespace App\Http\Controllers;

use App\Models\crudModel;
use App\Models\loginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class crud extends Controller
{
    public function index(){
        $modelCrud = new crudModel;
        $data['items'] = $modelCrud  -> get();
        return view('index',$data);
    }

    public function all(){
        $modelCrud = new crudModel;
        $data = $modelCrud -> where('user',session('id')) -> get();
        return response()->json($data);
    }
    public function save(Request $request){
        $taskModel = new crudModel;
        $validator = Validator::make($request->all(), [
            'task' => 'required',
        ]);

        if ($validator->fails()) {
            $res = ['success' => FALSE, 'message' => $validator->errors()];
            return response()->json($res); exit;
        }
        $validated = $validator->validated();
        
        $task = $validated['task'];
        $inserted = $taskModel->insertGetId(['task' => $task,'user' => session('id')]);
        if($inserted){
            $res = ['success' => true, 'message' => 'Task Added Successfully', 'id' => $inserted];
            return response()->json($res); exit;
        }
        $res = ['success' => FALSE, 'message' => 'Enter a valid User name or password.!'];
        return response()->json($res);
    }

    public function toggle(Request $request){
        $id = $request->id;
        // $taskModel = new crudModel;
        $data = crudModel::find($id);
        if($data->status==1){
            $data->status=0;
        }else{
            $data->status=1;
        }
        $data->save();
        $res = ['success' => true, 'message' => 'Task status Changed'];
        return response()->json($res);
    }

    public function delete(Request $request){
        $id = $request->id;
        // $taskModel = new crudModel;
        $data = crudModel::find($id)->delete();
        $res = ['success' => true, 'message' => 'Task Deleted '];
        return response()->json($res);
    }

    public function hardDelete(Request $request){
        $id = $request->id;
        $data = crudModel::withTrashed(true)->find($id)->forceDelete();
        $res = ['success' => true, 'message' => 'Task Deleted From Trash'];
        return response()->json($res);
    }

    public function restore(Request $request){
        $id = $request->id;
        $data = crudModel::withTrashed(true)->find($id)->restore();
        $res = ['success' => true, 'message' => 'Task Restored From Trash'];
        return response()->json($res);
    }

    public function getTrash(){
        $modelCrud = new crudModel;
        $items = $modelCrud -> onlyTrashed()->where('user',session('id')) -> get();
        // dd($data);
        return response()->json($items);
        // return view('index',$data);
    }

    public function completed(){
        $modelCrud = new crudModel;
        $data = $modelCrud -> where('status',1)->where('user',session('id')) -> get();
        // dd($data);
        return response()->json($data);
    }

    public function incomplete(){
        $modelCrud = new crudModel;
        $data = $modelCrud ->where('status',0) -> where('user',session('id')) -> get();
        return response()->json($data);
    }

    public function update(Request $request){
        $id = $request->id;
        $task = $request->task;
        // $taskModel = new crudModel;
        $data = crudModel::withTrashed(true)->find($id);

            $data->task=$task;
        
        $data->save();
        $res = ['success' => true, 'message' => 'Task status Changed'];
        return response()->json($res);
    }

    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            $res = ['success' => FALSE, 'message' => $validator->errors()];
            return response()->json($res); exit;
        }
        $validated = $validator->validated();
        
        $email = $validated['email'];
        $pwd  = $validated['password'];

            $check = loginModel::where('email', $email)
                      ->where('password', md5($pwd))
                      ->first();
            if (isset($check->id)):
               
                $request->session()->put('id', $check->id);
                $request->session()->put('email', $check->email);
                $res = ['success' => TRUE, 'message' => 'Login successfully', 'url' => url('/')];
            else:
                $res = ['success' => FALSE, 'message' => 'Enter a valid User name or password.!'];
            endif;
        return response()->json($res);
    }

    public function LogOut(Request $request)
    {
        $request->session()->forget('id');
        $request->session()->forget('email');
        $request->session()->flush();
        return redirect('/');
    }

    public function reg(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
         'email'  => 'required|email|unique:login,email',
         'password'  =>'required|min:6',
         'confirm_password' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator->fails()) {
            $res = ['success' => FALSE, 'message' => $validator->errors()];
            return response()->json($res); exit;
        }
        
        $validated = $validator->validated();
        if ($validated):
            $data=[
                   'email'=>$request->email,
                   'password'=>md5($request->password),
                   'created_at' => now()];
            if (LoginModel::insert($data)):
                
                $res = ['success' => TRUE, 'message' => 'User added successfully', 'url' => url('login')];
            else:
                $res = ['success' => FALSE, 'message' => 'User not added.!'];
            endif;
            return response()->json($res);
        endif;
    }

}
