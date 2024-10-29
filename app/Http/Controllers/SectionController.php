<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return view('section.section' ,compact('sections'));
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
            'name' => 'required|unique:sections',
        ],[
            'name.required' => 'هذا الحقل مطلوب',
            'name.unique' => 'القسم مستخدم من قبل',
        ]);


            $newSection = Section::create([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => auth()->user()->name
            ]);

            if($newSection)
                return back()->with('success','تم اضافة القسم بنجاح');
        
        }
    

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => ['required',Rule::unique('sections')->ignore($section->id),],
        ],[
            'name.required' => 'هذا الحقل مطلوب',
            'name.unique'=> 'القسم مستخدم من قبل'
        ]);

        $section->update($request->all());

        return back()->with('success','تم تعديل القسم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function delete($section)
    {
        Section::find($section)->delete();

        return back()->with('success','تم حذف القسم بنجاح');
        
    }
}
