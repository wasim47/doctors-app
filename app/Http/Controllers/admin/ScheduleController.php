<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\ScheduleService;
use App\Services\CommonService;
use Illuminate\Http\Request;

class ScheduleController extends BaseController
{
    public function __construct(
        protected ScheduleService $service,
        protected CommonService $commonService
    ) {}

    public function index()
    {
        $listData = $this->service->index();
        return view('admin.schedule.index', compact('listData'));
    }

    public function create()
    {
        $doctorList = $this->commonService->doctorList();
        return view('admin.schedule.create', compact('doctorList'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'days_of_weeks' => 'required',
             'shift' => 'required|array',
            'shift.*' => 'nullable|string|max:255',
            'start_time' => 'required|array',
            'start_time.*' => 'nullable',
            'end_time' => 'required|array',
            'end_time.*' => 'nullable|after:start_time.*',
            'minutes_per_appointment' => 'required|array',
            'minutes_per_appointment.*' => 'required|integer|min:1|max:1440',
            'maximum_patients' => 'required|array',
            'maximum_patients.*' => 'required|integer|min:1',
        ]);
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->store($data);
        return redirect()->route('schedule.index')->with('success', 'Schedule created successfully.');
    }

    public function show(int $id)
    {
        return response()->json($this->service->find($id));
    }

    public function edit(int $id)
    {
        $schedule = $this->service->find($id);
        $doctorList = $this->commonService->doctorList();
        return view('admin.schedule.edit', compact('schedule','doctorList'));
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'days_of_weeks' => 'required|string|min:1|max:7',
            'shift' => 'required|array',
            'shift.*' => 'nullable|string|max:255',
            'start_time' => 'required|array',
            'start_time.*' => 'nullable|',
            'end_time' => 'required|array',
            'end_time.*' => 'nullable|after:start_time.*',
            'minutes_per_appointment' => 'required|array',
            'minutes_per_appointment.*' => 'required|integer|min:1|max:1440',
            'maximum_patients' => 'required|array',
            'maximum_patients.*' => 'required|integer|min:1',
        ]);
        
        
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        dd($data);

        $this->service->update($id, $data);
        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }
}
