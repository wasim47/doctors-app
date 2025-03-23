<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\UserService;
use App\Services\CommonService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(
        protected UserService $service,
        protected CommonService $commonService
    ) {}

    public function index()
    {
        $listData = $this->service->index();
        return view('admin.user.index', compact('listData'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_no' => 'required|unique:users,mobile', // It's good practice to define max length
            'email' => 'required|email|unique:users,email', // Fixed email validation
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other,Not Declare',
        ]);
        
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->store($data);
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function show(int $id)
    {
        return response()->json($this->service->find($id));
    }

    public function edit(int $id)
    {
        $user = $this->service->find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:20|unique:users,mobile,' . $id, // Fixed unique rule for update
            'email' => 'required|email|unique:users,email,' . $id, // Fixed unique rule for update
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other,Not Declare',
        ]);
        
        
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->update($id, $data);
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
}
