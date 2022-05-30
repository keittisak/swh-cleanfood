<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Menu;
use DB;
use DataTables;

class MenuController extends Controller
{
    public function index (Request $request)
    {
        return view('product_menu.index');
    }

    public function data (Request $request)
    {
        $menus = Menu::all();
        return DataTables::of($menus)
        ->addColumn('action', function($menu) {
            return '<a href="'.route('products.menu.edit', $menu->id).'" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteAction.deleteRow('.$menu->id.')"><i class="fa fa-times"></i></button>';
        })
        ->rawColumns(['checkbox','action'])
        ->make(true);
    }

    public function create (Request $request)
    {
        $data = [
            'action' => 'create'
        ];
        return view('product_menu.form', $data);
    }

    public function store (Request $request)
    {
        if (isset($request->user()->id)){
            $request->merge(array('created_by' => $request->user()->id));
            $request->merge(array('updated_by' => $request->user()->id));
        }

        $validate = [
            'name' => 'required',
            'type' => [
                'required',
                'in:spicy,soft'
            ],
            'detail' => 'max:255',
        ];

        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $menu = DB::transaction(function() use($request, $data) {
                $menu = new Menu();
                $menu = $menu->create($data);
                return $menu;
            });
            return response($menu,'201');
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    public function edit (Request $request, int $id)
    {
        $menu = Menu::findOrFail($id);
        $data = [
            'action' => 'edit',
            'menu' => $menu,
        ];
        return view('product_menu.form', $data);
    }

    public function update (Request $request, int $id)
    {
        if (isset($request->user()->id)){
            $request->merge(array('updated_by' => $request->user()->id));
        }
        $validate = [
            'name' => 'required',
            'type' => [
                'required',
                'in:spicy,soft'
            ],
            'detail' => 'max:255',
        ];

        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $menu = DB::transaction(function() use($request, $data, $id) {
                $menu = Menu::findOrFail($id);
                $menu->update($data);
                return $menu;
            });
            return response($menu,'201');
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    public function destroy (Request $request, int $id)
    {
        try{
            $menu = Menu::findOrFail($id);
            if($request->user()->id){
                $menu->updated_by = $request->user()->id;
            }
            $menu->update();
            $menu->delete();
            return response('','204');
        } catch (\Exception $e) {
            return response(['message' =>$e->getMessage()],'500');
        }
    }
}
