<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('product.product',compact(['products','sections']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'section_id'=>'required',
        ],[
            'name.required' => 'المنتج مطلوب',
            'section_id.required' => 'القسم مطلوب'
        ]);
        
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'section_id' => $request->section_id
        ]);

        
        return back()->with('success','تم اضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required',
            'section_id'=>'required',
        ],[
            'name.required' => 'المنتج مطلوب',
            'section_id.required' => 'القسم مطلوب'
        ]);

        $product->update($request->all());

        return back()->with('success','تم تعديل المنتج بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($product)
    {
        Product::findOrFail($product)->delete();

        return back()->with('success','تم حذف المنتج بنجاح');
    }
}
