<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories=Category::all();
        return view('admin.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string|max:255',
            'slug'=>'required|string|max:255',
            'image'=>'nullable|image',
            'description'=>'nullable|string|max:255',
        ]);

        if($request->hasFile('image')){
            $image=$request->file('image');
            $image_name=uniqid().'_'.$image->getClientOriginalName();
            $image->move(public_path('images'),$image_name);
            $data['image']=$image_name;
        }

        Category::create($data);
        return redirect()->route('admin.category.index')->with('success','Category created successfully');
    }

    public function edit($id)
    {
        $category=Category::findOrFail($id);
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request ,$id)
    {
        $data=$request->validate([
            'name'=>'required|string|max:255',
            'slug'=>'required|string|max:255',
            'image'=>'nullable|image',
            'description'=>'nullable|string|max:255',
        ]);

        $category=Category::findOrFail($id);
        if($request->hasFile('image') && $category->image){
            unlink(public_path('images/'.$category->image));
        }

        if($request->hasFile('image')){
            $image=$request->file('image');
            $image_name=uniqid().'_'.$image->getClientOriginalName();
            $image->move(public_path('images'),$image_name);
            $data['image']=$image_name;
        }

       

        $category->update($data);
        return redirect()->route('admin.category.index')->with('success','Category updated successfully');

    }

    public function delete($id)
    {
        $category=Category::findOrFail($id);
        if($category->image){
            unlink(public_path('images/'.$category->image));
        }
        $category->delete();
        return redirect()->route('admin.category.index')->with('success','Category deleted successfully');
    }
    public function updateToggle(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->status = $request->state; 

        $category->save();
    
        return response()->json(['success' => true, ]);
    }
    
}
