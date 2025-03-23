<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\DoctorService;
use App\Services\CommonService;
use Illuminate\Http\Request;

class DoctorController extends BaseController
{
    public function __construct(
        protected DoctorService $service,
        protected CommonService $commonService
    ) {}

    public function index()
    {
        $listData = $this->service->index();
        return view('admin.doctor.index', compact('listData'));
    }

    public function create()
    {
        $specialityList = $this->commonService->specialityList();
        $hospitalList = $this->commonService->hospitalList();
        $branchList = $this->commonService->branchList();
        return view('admin.doctor.create', compact('specialityList','hospitalList','branchList'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'speciality_id' => 'required|array',
            'branch_id' => 'required|array',
            'email' => 'required|email|unique:doctors|max:255',
            'phone_no' => 'required|unique:doctors|max:255',
            'gender' => 'required|in:Male,Female,Other,Not Declare',
            'regular_fee' => 'nullable|numeric',
            'report_fee' => 'nullable|numeric',
        ]);
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->store($data);
        return redirect()->route('doctor.index')->with('success', 'Doctor created successfully.');
    }

    public function show(int $id)
    {
        return response()->json($this->service->find($id));
    }

    public function edit(int $id)
    {
        $doctor = $this->service->find($id);
        $specialityList = $this->commonService->specialityList();
        $hospitalList = $this->commonService->hospitalList();
        $branchList = $this->commonService->branchList();
        return view('admin.doctor.edit', compact('doctor','specialityList','hospitalList','branchList'));
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'speciality_id' => 'required|array',
            'branch_id' => 'required|array',
            'phone_no' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'regular_fee' => 'nullable|numeric',
            'report_fee' => 'nullable|numeric',
        ]);
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->update($id, $data);
        return redirect()->route('doctor.index')->with('success', 'Doctor updated successfully.');
    }
}
