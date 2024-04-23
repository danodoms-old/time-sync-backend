<?php

namespace App\Http\Controllers\Api;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index(){

        $schedules = Schedule::all();

        if($schedules->count() > 0){
            return response()->json([
                'status' => 200,
                'schedules' => $schedules
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'schedules' => "No records found"
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
            $schedule = Schedule::create([
                'name' => $request->name
            ]);

            if($schedule){
                return response()->json([
                    'status'=> 200,
                    'message'=> "Schedule added successfully"
                    ], 200);
            }else{
                return response()->json([
                    'status'=> 500,
                    'message'=> "Adding schedule failed"
                    ], 500);
            }
        }
    }
}
