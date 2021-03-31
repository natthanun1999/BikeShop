<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Config, Validator;

class ProductController extends Controller
{
    var $rp = 10;

    public function __construct() {
        $this->rp = Config::get('app.result_per_page');
    }

    public function index() {
        $products = Product::paginate($this->rp);

        return view('product/index', compact('products'));
    }

    public function search(Request $request) {
        $query = $request->q;

        if ($query) {
            $products = Product::where('code', 'like', '%'.$query.'%')
            ->orWhere('name', 'like', '%'.$query.'%')
            ->paginate($this->rp);
        } else {
            $products = Product::paginate($this->rp);
        }

        return view('product/index', compact('products'));
    }

    public function insert(Request $request) {
        $rules = array(
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required|numeric',
            'price' => 'numeric',
            'stock_qty' => 'numeric'
        );

        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข'
        );

        $temp = array(
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock_qty' => $request->stock_qty,
        );

        $validator = Validator::make($temp, $rules, $messages);

        if ($validator->fails()) {
            return redirect('product/edit')
                   ->withErrors($validator)
                   ->withInput();
        }

        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;

        if ($request->hasFile('image')) {
            $f = $request->file('image');

            $upload_to = 'upload/images';

            $relative_path = $upload_to.'/'.$f->getClientOriginalName();
            $absolute_path = public_path().'/'.$upload_to;

            $f->move($absolute_path, $f->getClientOriginalName());

            $product->image_url = $relative_path;

            Image::make(public_path().'/'.$relative_path)->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
        }

        $product->save();

        return redirect('product')
                ->with('ok', true)
                ->with('msg', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id = null) {
        $categories = Category::pluck('name', 'id')->prepend('เลือกรายการ', '');

        if ($id) {
            //$product = Product::find($id);
            $product = Product::where('id', $id)->first();
            
            return view('product/edit')
                   ->with('product', $product)
                   ->with('categories', $categories);
        } else {
            return view('product/add')->with('categories', $categories);
        }
    }

    public function update(Request $request) {
        $rules = array(
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required|numeric',
            'price' => 'numeric',
            'stock_qty' => 'numeric'
        );

        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข'
        );

        $id = $request->id;
        $temp = array(
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock_qty' => $request->stock_qty,
        );

        $validator = Validator::make($temp, $rules, $messages);

        if ($validator->fails()) {
            return redirect('product/edit/'.$id)
                   ->withErrors($validator)
                   ->withInput();
        }

        $product = Product::find($id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;

        if ($request->hasFile('image')) {
            $f = $request->file('image');

            $upload_to = 'upload/images';

            $relative_path = $upload_to.'/'.$f->getClientOriginalName();
            $absolute_path = public_path().'/'.$upload_to;

            $f->move($absolute_path, $f->getClientOriginalName());

            $product->image_url = $relative_path;

            Image::make(public_path().'/'.$relative_path)->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
        }

        $product->save();

        return redirect('product')
               ->with('ok', true)
               ->with('msg', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function remove($id) {
        Product::find($id)->delete();
        
        return redirect('product')
               ->with('ok', true)
               ->with('msg', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
