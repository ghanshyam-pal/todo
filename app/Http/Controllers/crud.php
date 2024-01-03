<?php

namespace App\Http\Controllers;

use App\Models\crudModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class crud extends Controller
{
    public function index(){
        $modelCrud = new crudModel;
        $data['items'] = $modelCrud -> get();
        return view('index',$data);
    }

    public function all(){
        $modelCrud = new crudModel;
        $data = $modelCrud -> get();
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
        $inserted = $taskModel->insertGetId(['task'=>$task]);
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
        $items = $modelCrud -> onlyTrashed()-> get();
        // dd($data);
        return response()->json($items);
        // return view('index',$data);
    }

    public function completed(){
        $modelCrud = new crudModel;
        $data = $modelCrud -> where('status',1)-> get();
        // dd($data);
        return response()->json($data);
    }

    public function incomplete(){
        $modelCrud = new crudModel;
        $data = $modelCrud ->where('status',0)-> get();
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
}
