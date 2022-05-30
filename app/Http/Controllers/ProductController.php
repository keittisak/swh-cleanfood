<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Menu;
use DB;
use DataTables;

class ProductController extends Controller
{
    public function index (Request $request)
    {
        return view('products.index');
    }

    public function data (Request $request)
    {
        $products = Product::all();
        return DataTables::of($products)
            ->addColumn('action', function($product) {
                return '<a href="'.route('products.edit', $product->id).'" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteAction.deleteRow('.$product->id.')"><i class="fa fa-times"></i></button>';
            })
            ->rawColumns(['checkbox','action'])
        ->make(true);
    }

    public function create (Request $request)
    {
        $menus = [];
        foreach(Menu::all() as $menu){
            $menus[$menu->type][] = $menu;
        }
        $data = [
            'action' => 'create',
            'menus' => $menus
        ];
        return view('products.form', $data);
    }

    public function store (Request $request)
    {
        if (isset($request->user()->id)){
            $request->merge(array('created_by' => $request->user()->id));
            $request->merge(array('updated_by' => $request->user()->id));
        }
        if($request->type === 'exclusive'){
            unset($request['menu_ids']);
        }
        $validate = [
            'name' => 'required',
            'type' => [
                'required',
                'in:material,exclusive'
            ],
            'detail' => 'max:255',
            'price' => [
                'numeric',
                'min:0'
            ],
            "menu_ids" => [
                'array'
            ],
            'created_by' =>[
                'integer'
            ],
            'updated_by' => [
                'integer'
            ]
        ];

        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $product = DB::transaction(function() use($request, $data) {
                $product = new Product();
                $product = $product->create($data);
                if (isset($request->menu_ids)){
                    $product->menus()->sync($request->menu_ids);
                }
                return $product;
            });
            return response($product,'201');
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    public function edit (Request $request, int $id)
    {
        $product = Product::with('menus')->findOrFail($id);
        $menus = [];
        foreach(Menu::all() as $menu){
            $menus[$menu->type][] = $menu;
        }
        $data = [
            'action' => 'edit',
            'menus' => $menus,
            'product' => $product
        ];
        return view('products.form', $data);
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
                'in:material,exclusive'
            ],
            'detail' => 'max:255',
            'price' => [
                'numeric',
                'min:0'
            ],
            "menu_ids" => [
                'array'
            ],
            'updated_by' =>[
                'integer'
            ]
        ];

        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $product = DB::transaction(function() use($request, $data, $id) {
                $product = Product::findOrFail($id);
                $product->update($data);
                if (isset($request->menu_ids)){
                    $product->menus()->sync($request->menu_ids);
                }else{
                    $product->menus()->sync([]);
                }
                return $product;
            });
            return response($product,'201');
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    public function destroy (Request $request, int $id)
    {
        try{
            $product = Product::findOrFail($id);
            if($request->user()->id){
                $product->updated_by = $request->user()->id;
            }
            $product->update();
            $product->delete();
            return response('','204');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response(['message' =>$message],'500');
        }
    }
}
