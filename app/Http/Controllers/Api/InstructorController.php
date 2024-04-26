<?php

namespace App\Http\Controllers\Api;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InstructorController extends Controller
{
    public function index(){

        $instructors = Instructor::all();

        if($instructors->count() > 0){
            return response()->json([
                'status' => 200,
                'instructors' => $instructors
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'instructors' => "No records found"
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
            $instructor = Instructor::create([
                'name' => $request->name
            ]);

            if($instructor){
                return response()->json([
                    'status'=> 200,
                    'message'=> "Instructor added successfully",
                    'instructor' => $instructor

                    ], 200);
            }else{
                return response()->json([
                    'status'=> 500,
                    'message'=> "Adding instructor failed"
                    ], 500);
            }
        }
    }
}
