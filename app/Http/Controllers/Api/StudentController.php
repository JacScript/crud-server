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
            'course' => 'required|string|max:191',
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

    public function show($id){
        $student = Student::find($id);
        if($student){
            $data = [
                'status' => 200,
                'student' => $student
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'Student not found'
            ];
            return response()->json($data, 404);
        }
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
            'course' => 'required|string|max:191',
        ]);

        if($validator->fails()){
            $data = [
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 422);
        } else {
            $student = Student::find($id);
            if($student){
                $student->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'course' => $request->course,
                ]);

                $data = [
                    'status' => 200,
                    'message' => 'Student updated successfully',
                    'student' => $student
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'status' => 404,
                    'message' => 'Student not found'
                ];
                return response()->json($data, 404);
            }
        }
    }

    public function destroy($id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            $data = [
                'status' => 200,
                'message' => 'Student deleted successfully'
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'Student not found'
            ];
            return response()->json($data, 404);
        }
    }
}
