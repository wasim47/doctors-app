<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\PatientService;
use App\Services\CommonService;
use Illuminate\Http\Request;

class PatientController extends BaseController
{
    public function __construct(
        protected PatientService $service,
        protected CommonService $commonService
    ) {}

    public function index()
    {
        $listData = $this->service->index();
        return view('admin.patient.index', compact('listData'));
    }

    public function create()
    {
        return view('admin.patient.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other,Not Declare',
        ]);
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->store($data);
        return redirect()->route('patient.index')->with('success', 'Patient created successfully.');
    }

    public function show(int $id)
    {
        return response()->json($this->service->find($id));
    }

    public function edit(int $id)
    {
        $patient = $this->service->find($id);
        return view('admin.patient.edit', compact('patient'));
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other,Not Declare',
        ]);
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->update($id, $data);
        return redirect()->route('patient.index')->with('success', 'Patient updated successfully.');
    }
}
