<?php

namespace App\Http\Controllers\ResultManagement;

use App\Entities\ResultManagement\Semester;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesters = Semester::latest()->paginate(5);

        return view('resultmanagement.semesters.index',compact('semesters'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resultmanagement.semesters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'program_id' => 'required',
            'code' => '',
            'name' => 'required',
            'type' => '',
            'description' => '',
            'year ' => '',
            'start_date ' => '',
            'end_date ' => '',
        ]);
        Semester::create($request->all());

        return redirect()->route('semesters.index')
            ->with('success','Semester created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $semester = Semester::find($id);
        return view('resultmanagement.semesters.show',compact('semester'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $semester = Semester::find($id);
        return view('resultmanagement.semesters.edit',compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'program_id' => 'required',
            'code' => '',
            'name' => 'required',
            'type' => '',
            'description' => '',
            'year ' => '',
            'start_date ' => '',
            'end_date ' => '',
        ]);

        Semester::find($id)->update($request->all());
        return redirect()->route('semesters.index')
            ->with('success','Semester updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Semester::find($id)->delete();
        return redirect()->route('semesters.index')
            ->with('success','Semester deleted successfully');
    }
}
