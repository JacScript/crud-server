<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();
        if($students->count() > 0){

            $data = [
                'status' => 200,
                'students' => $students
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No student found'
            ];
            return response()->json($data, 404);
        }
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
            'course' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            $data = [
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 422);
        } else {
            $student = Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'course' => $request->course,
            ]);

            if($student){
                $data = [
                    'status' => 201,
                    'message' => 'Student created successfully',
                    'student' => $student
                ];
                return response()->json($data, 201);
            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Failed to create student'
                ];
                return response()->json($data, 500);
            }
        }


       
    }
}
