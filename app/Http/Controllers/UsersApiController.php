<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Validator;

class UsersApiController extends Controller
{
    public function showUser($id=null) {
        if ($id == '') {
            $users = User::get();
            return response()->json(["users"=>$users], 200);
        } else {
            $users = User::find($id);
            return response()->json(["users"=>$users], 200);            
        }
    }

    public function addUser(Request $request) {
        if ($request->ismethod('post')) {
            $data = $request->all();
            // return $data;
            $rules = [
                'name'=> 'required',
                'email'=> 'required|email|unique:users',
                "password"=> 'required' 
            ];

            $customMessage = [
                'name.required'=> 'Name is required',
                'email.required'=> 'Email is required',
                'email.email'=> 'Email must be a valid email',
                'password.required'=> 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = new User();
            
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->password = bcrypt($data['password']);

            $user->save();

            $message = "User Succesfully Added";
            return response()->json(['message'=>$message], 201);
        }
    }

    public function addMultipleUser(Request $request) {
        if ($request->ismethod('post')) {
            $data = $request->all();
            // return $data;
            $rules = [
                'users.*.name'=> 'required',
                'users.*.email'=> 'required|email|unique:users',
                "users.*.password"=> 'required' 
            ];

            $customMessage = [
                'users.*.name.required'=> 'Name is required',
                'users.*.email.required'=> 'Email is required',
                'users.*.email.email'=> 'Email must be a valid email',
                'users.*.password.required'=> 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            foreach($data['users'] as $addUser) {
                $user = new User();
                
                $user->name = $addUser["name"];
                $user->email = $addUser["email"];
                $user->password = bcrypt($addUser['password']);

                $user->save();
                $message = "Users Succesfully Added";
            }
            
            return response()->json(['message'=>$message], 201);
        }
    }

    public function updateUser(Request $request, $id) {
        if ($request->ismethod('put')) {
            $data = $request->all();
            // return $data;
            $rules = [
                'name'=> 'required',
                "password"=> 'required' 
            ];

            $customMessage = [
                'name.required'=> 'Name is required',
                'email.required'=> 'Email is required',
                'email.email'=> 'Email must be a valid email',
                'password.required'=> 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::findorFail($id);
            
            $user->name = $data["name"];
            $user->password = bcrypt($data['password']);

            $user->save();

            $message = "User Succesfully Updated";
            return response()->json(['message'=>$message], 202);
        }
    }

    public function updateUserSingleRecord(Request $request, $id) {
        if ($request->ismethod('patch')) {
            $data = $request->all();

            $rules = [
                'name'=> 'required'
            ];

            $customMessage = [
                'name.required'=> 'Name is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::findorFail($id);
            
            $user->name = $data["name"];
            
            $user->save();

            $message = "User Succesfully Updated";
            return response()->json(['message'=>$message], 201);
        }
    }

    public function deleteUser($id=null) {
        User::findOrFail($id)->delete();

        $message = "User Succesfully Deleted";
        return response()->json(['message'=>$message], 200);
    }

    public function deleteUserJSON(Request $request) {
        $header = $request->header("Authorization");

        if ($header) {
            $message = "Authorization is requried";
            return response()->json(['message'=>$message], 200);
        } else {
            if ($request->isMethod('delete')) {
                $data = $request->all();
    
                User::where('id', $data['id'])->delete();
                $message = "User Succesfully Deleted";
                return response()->json(['message'=>$message], 200);
            }
        }
    }
}
