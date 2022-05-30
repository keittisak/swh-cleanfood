<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;
use DataTables;

class UserController extends Controller
{
    public function index (Request $request)
    {
        $data = array(
            'pageTitle' => 'Users',
            'pageSubTitle' => 'ผู้ใช้งาน',
        );
        return view('users.index', $data);
    }

    public function data (Request $request)
    {
        $users = User::all();
        return DataTables::of($users)
            ->addColumn('action', function($user) {
                return '<a href="'.route('users.edit', $user->id).'" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteAction.deleteRow('.$user->id.')"><i class="fa fa-times"></i></button>';
            })
            ->rawColumns(['checkbox','action'])
        ->make(true);
    }

    public function create (Request $request)
    {
        $user = new User;
        $data = array(
            'pageTitle' => 'Users | Create',
            'pageSubTitle' => 'Create User',
            'action' => 'create',
            'user' => $user
        );
        return view('users.form', $data);
    }

    public function edit (Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $data = array(
            'pageTitle' => 'Users | Edit',
            'pageSubTitle' => 'Edit User',
            'action' => 'edit',
            'user' => $user
        );
        return view('users.form', $data);
    }

    public function store (Request $request)
    {
        $validate = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ];
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $user = DB::transaction(function() use($request, $data) {
                $user = new User();
                $data['password'] = Hash::make($request->password);
                $user->create($data);
                return $user;
            });
            return response($user, 201);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],500);
        }
    }

    public function update (Request $request, int $id)
    {
        if(!$request->passowrd){
            $request->request->remove('password');
        }
        $validate = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$id],
            'password' => ['string','min:6'],
        ];
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $user = DB::transaction(function() use($request, $data, $id) {
                $user = User::findOrFail($id);
                $data['password'] = Hash::make($request->password);
                $user->update($data);
                return $user;
            });
            return response($user,200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],500);
        }
    }

    public function destroy (Request $request, int $id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response('','204');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response(['message' =>$message],'500');
        }
    }
}
