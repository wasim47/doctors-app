<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\BranchService;
use App\Services\CommonService;
use Illuminate\Http\Request;

class BranchController extends BaseController
{
    public function __construct(
        protected BranchService $service,
        protected CommonService $commonService
    ) {}

    public function index()
    {
        $listData = $this->service->index();
        return view('admin.branch.index', compact('listData'));
    }

    public function create()
    {
        $hospitalList = $this->commonService->hospitalList();
        return view('admin.branch.create', compact('hospitalList'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'hospital_id' => 'required',
        ], [
            'name.required' => 'The branch name is required.',
            'name.max' => 'The branch name must not exceed 255 characters.',
            'hospital_id.required' => 'Hospital is required.',
        ]);
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->store($data);
        return redirect()->route('branch.index')->with('success', 'Branch created successfully.');
    }

    public function show(int $id)
    {
        return response()->json($this->service->find($id));
    }

    public function edit(int $id)
    {
        $branch = $this->service->find($id);
        $hospitalList = $this->commonService->hospitalList();
        return view('admin.branch.edit', compact('branch','hospitalList'));
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'hospital_id' => 'required',
        ], [
            'name.required' => 'The branch name is required.',
            'name.max' => 'The branch name must not exceed 255 characters.',
            'hospital_id.required' => 'Hospital is required.',
        ]);
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->update($id, $data);
        return redirect()->route('branch.index')->with('success', 'Branch updated successfully.');
    }
}
