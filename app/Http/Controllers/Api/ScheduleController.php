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
            'subject_id' => 'required|exists:subjects,id',
            'instructor_id' => 'required|exists:instructors,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'
            
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $schedule = Schedule::create([
                'subject_id' => $request->subject_id,
                'instructor_id' => $request->instructor_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'day_of_week' => $request->day_of_week
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
