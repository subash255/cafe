<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fooditems;
use Illuminate\Http\Request;

class FooditemsController extends Controller
{
    public function index()
    {
        $fooditems=Fooditems::all();
        $categories=Category::all();
        return view('admin.fooditem.index',compact('fooditems','categories'));
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string|max:255',
            'slug'=>'required|string|max:255',
            'image'=>'nullable|image',
            'description'=>'nullable|string|max:255',
            'price'=>'required|numeric',
            'category_id'=>'required|exists:categories,id',
            'type'=>'required|string',
        ]);

        if($request->hasFile('image')){
            $image=$request->file('image');
            $image_name=uniqid().'_'.$image->getClientOriginalName();
            $image->move(public_path('fooditem'),$image_name);
            $data['image']=$image_name;
        }

        Fooditems::create($data);
        return redirect()->route('admin.fooditem.index')->with('success','Fooditem created successfully');
    }

    public function edit($id)
    {
        $fooditem=Fooditems::findOrFail($id);
        $categoryId=$fooditem->category_id;
        $categories=Category::where('id' ,$categoryId)->get();
        return view('admin.fooditem.edit',compact('fooditem','categories'));
    }  
    
    public function update(Request $request ,$id)
    {
        $data= $request->validate([
            'name'=>'required|string|max:255',
            'slug'=>'required|string|max:255',
            'image'=>'nullable|image',
            'description'=>'nullable|string|max:255',
            'price'=>'required|numeric',
            'category_id'=>'required|exists:categories,id',
            
        ]);

        $fooditem=Fooditems::findOrFail($id);

        if($request->hasFile('image') && $fooditem->image){
            unlink(public_path('fooditem/'.$fooditem->image));
        }

        if($request->hasFile('image')){
            $image=$request->file('image');
            $image_name=uniqid().'_'.$image->getClientOriginalName();
            $image->move(public_path('fooditem'),$image_name);
            $data['image']=$image_name;
        }

        $fooditem->update($data);
        return redirect()->route('admin.fooditem.index')->with('success','Fooditem updated successfully');
    }

    public function delete($id)
    {
        $fooditem=Fooditems::findOrFail($id);
        if($fooditem->image){
            unlink(public_path('fooditem/'.$fooditem->image));
        }
        $fooditem->delete();
        return redirect()->route('admin.fooditem.index')->with('success','Fooditem deleted successfully');
    }

    public function updateToggle( Request $request,$fooditemId)
    {
        $fooditem=Fooditems::findOrFail($fooditemId);
        $fooditem->status=$request->state;
        $fooditem->save();
        return response()->json(['success' => true, ]);
    }
}
