<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Product;
use App\Menu;
use DB;
use DataTables;

class CourseController extends Controller
{
    public function index (Request $request)
    {
        return view('courses.index');
    }
    public function data (Request $request)
    {
        $courses = Course::all();
        return DataTables::of($courses)
            ->addColumn('action', function($course) {
                return '<a href="'.route('courses.edit', $course->id).'" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteAction.deleteRow('.$course->id.')"><i class="fa fa-times"></i></button>';
            })
            ->rawColumns(['checkbox','action'])
        ->make(true);
    }
    public function create (Request $request)
    {
        $course = new Course;
        $data = array(
            'action' => 'create',
            'products' => Product::with('menus')->get(),
            'course' => $course
        );
        return view('courses.form',$data);
    }
    public function store (Request $request)
    {
        if (isset($request->user()->id)){
            $request->merge(array('created_by' => $request->user()->id));
            $request->merge(array('updated_by' => $request->user()->id));
        }
        $validate = [
            'name' => [
                'required',
            ],
            'detail' => [
                'max:255'
            ],
            'items' => [
                'required'
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
                $course = new Course();
                $course = $course->create($data);
                return $course;
            });
            return response($course,'201');
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }

    public function edit (Request $request, int $id)
    {
        $course = Course::findOrFail($id);
        $products = Product::with('menus')->get();
        $menus = [];
        $productKey = [];
        foreach($products as $product){
            $productKey[$product->id] = $product;
            $menus[$product->id] = $product->menus;
        }
        $data = array(
            'action' => 'edit',
            'products' => $products,
            'productKey' => $productKey,
            'menus' => $menus,
            'course' => $course
        );
        return view('courses.form',$data);
    }

    public function update (Request $request, int $id)
    {
        if (isset($request->user()->id)){
            $request->merge(array('created_by' => $request->user()->id));
            $request->merge(array('updated_by' => $request->user()->id));
        }
        $validate = [
            'name' => [
                'required',
            ],
            'detail' => [
                'max:255'
            ],
            'items' => [
                'required'
            ],
            'updated_by' => [
                'integer'
            ]
        ];
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $course = DB::transaction(function() use($request, $data, $id) {
                $course = Course::findOrFail($id);
                $course->update($data);
                return $course;
            });
            return response($course,'203');
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],500);
        }
    }

    public function destroy (Request $request, int $id)
    {
        try{
            $course = Course::findOrFail($id);
            if($request->user()->id){
                $course->updated_by = $request->user()->id;
            }
            $course->update();
            $course->delete();
            return response('','204');
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],'500');
        }
    }
}
