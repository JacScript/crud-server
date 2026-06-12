<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class Learing extends Controller
   {
   public function index(){
     $student = Student::all();
     if($student -> count() > 0){
        $data = [
            'status' => 200,
            'students' => $student,
        ];
        return response() -> json($data, 200);
     } else {
        $data = [
            'status' => 404,
            'message' => 'No data Found!',
        ];
        return response() -> json($data, 404);
     }
   }

   public function store(Request $request)
   {
     $validator = Validator::make($request -> all(), [
          'name' => 'required | max:191',
          'phone' => 'required | digits:10',
          'email' => 'required | email | unique:students | max:191',
          'course' => 'required | string | max:191',
     ]);

     if($validator -> fails()) {
        $data = [
            'status' => 422,
            'message' => 'Validation Failed',
            'errors' => $validator -> errors(),
        ];
        return response() -> json($data, 422);
     }
     else {
        $student = Student::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'course' => $request -> course,
            'phone' => $request -> phone,
        ]);

        if($student){
            $data = [
                'status' => 200,
                'messega' => 'Student Created Successfuly',
                'student' => $student,
            ];
            return response() -> json($data, 200);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Failed To Created Student', 
            ];
            return response() -> json($data, 500);
        }
     }
   }

   public function show($id) {
    $student = Student::find($id);
    if($student) {
        $data = [
            'status' => 200,
            'student' => $student,
        ];
        return response() -> json($data, 200);
    } else {
        $data = [
            'status' => 404,
            'message' => 'No data Found',
        ];
        return response() -> json($data, 404);
    }
   }

   public function update(Request $request, $id) {
      $validator = Validator::make( $request -> all(), [
         'name' => 'required | max:191',
         'email' => 'required | email | max:191| unique:students',
         'course' => 'required | max:191',
         'phone' => 'required | digits:10', 
      ]);

      if($validator -> fails()) {
        $data = [
            'status' => 422,
            'message' => 'Validation Failed',
        ];
        return response() -> json($data, 422);
      } 
      else {
        $student = Student::update([
           'name' => $request -> name,
            'email' => $request -> email,
            'course' => $request -> course,
            'phone' => $request -> phone,
        ]);
        if($student) {
            $data = [
                'status' => 200,
                'message' => 'Student Uppdated Successfuly',
                'student' => $student,
            ];
            return response() -> json($data, 200);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Failed to Update',
            ];
            return response() -> json($data, 500);
        }
      }
   }

   public function destory($id){
     $student = Student::find($id);
     if($student){
        $student = Student::delete($id);
        $data = [
            'status' => 200,
            'message' => 'Student deleted Successfully', 
        ];
        return response() -> json($data, 200);
     } else {
        $data = [
            'status' => 500,
            'message' => 'Failed to delete',
        ];
        return response() -> json($data, 500);
     }
   }


   }
