<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index(){

        $subjects = Subject::all();

        if($subjects->count() > 0){
            return response()->json([
                'status' => 200,
                'subjects' => $subjects
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'subjects' => "No records found"
            ], 404); 
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $subject = Subject::create([
                'name' => $request->name
            ]);

            if($subject){
                return response()->json([
                    'status'=> 200,
                    'message'=> "Subject added successfully"
                    ], 200);
            }else{
                return response()->json([
                    'status'=> 500,
                    'message'=> "Adding subject failed"
                    ], 500);
            }
        }
    }
}