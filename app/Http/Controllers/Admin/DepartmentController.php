<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;

use App\User;

class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.departments')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $this->authorize('department.index');
        $departments  =   Department::all();
        //dd($departments);
        $users = User::get();
        return view('admin.department.index', compact('departments', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $this->authorize('department.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {        
        //dd($request->all());
        $this->authorize('department.create');

        $department = new Department();
        $department->name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ];
        $department->assigned_user_id = $request->assigned_user_id > 0 ? $request->assigned_user_id : null;
        $department->save();

        return redirect()->route('departments.index')->with('success', __('messages.department_created'));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {        
        $this->authorize('department.index');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {        
        $this->authorize('department.edit');
        $users = User::get();
        return view('admin.department.edit', compact('department', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {        
        $this->authorize('department.update');
        
        $department->name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ];
        $department->assigned_user_id = $request->assigned_user_id > 0 ? $request->assigned_user_id : null;
        $department->save();

        return redirect()->route('departments.index')->with('success', __('messages.department_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {        
        $this->authorize('department.delete');
        $department->delete();
        return redirect()->route('departments.index')->with('success', __('messages.department_deleted'));
    }
}
