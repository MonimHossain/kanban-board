<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        try{
            $data = Task::select('id','title','status')->get();

            return response()->json([
                'data' => $data,
                'status' => 'success',
                'message' => 'All list of task'
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function create(Request $request)
    {
        if($request?->data['title']){
            Task::create(
                [
                    'title' => $request?->data['title'],
                    'status' => 'todo'
                ]
            );
    
            return response()->json([
                'status' => 'success'
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed'
            ], 401);
        }
    }

    public function update(Request $request)
    {
        if($request?->data['id'] && $request?->data['status']){
            Task::where('id', $request?->data['id'])->update(['status' => $request?->data['status']]);

            return response()->json([
                'status' => 'success'
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed'
            ], 401);
        }
    }
}
