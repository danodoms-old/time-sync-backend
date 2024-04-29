<?php

namespace App\Http\Controllers\Api;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index(){

        // $schedules = Schedule::all();
        $schedules =  $this->formatByDay(Schedule::all());

        if($schedules){
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


    private function formatByDay($schedules)
    {
        // Define an array to map day names to their index
        $dayIndexMap = [
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6
        ];
    
        // Initialize an array to hold the converted schedules
        $convertedSchedules = [];
    
        // Initialize an array to hold the schedules for each day
        $daySchedules = array_fill(0, 7, ['day' => '', 'schedules' => []]);
    
        // Iterate through the original schedules and group them by day
        foreach ($schedules as $schedule) {
            $dayIndex = $dayIndexMap[strtolower($schedule->day_of_week)];
            $daySchedules[$dayIndex]['day'] = ucfirst($schedule->day_of_week); // Capitalize the day name
            $daySchedules[$dayIndex]['schedules'][] = [
                'name' => 'ITC ' . $schedule->subject_id,
                'instructor' => 'Instructor ' . $schedule->instructor_id,
                'start' => substr($schedule->start_time, 0, 5), // Extract HH:MM from the time string
                'end' => substr($schedule->end_time, 0, 5)
            ];
        }
    
        // Add the organized schedules to the convertedSchedules array
        foreach ($daySchedules as $daySchedule) {
            // Include the day in the output regardless of whether there are schedules assigned to it
            $convertedSchedules[] = $daySchedule;
        }
    
        return $convertedSchedules;
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
