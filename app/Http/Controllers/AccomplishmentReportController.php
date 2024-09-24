<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccomplishmentReport;
use Illuminate\Http\Request;

class AccomplishmentReportController extends Controller
{
    public function create()
    {
        return view('reports.create', [
            'positions' => ['ERP Consultant', 'Functional', 'Marketing', 'Accounting', 'ERP Technical/Developer']
        ]);
    }

    public function store(Request $request)
    {
        // Validate the input based on the dynamic fields
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'task.*' => 'required|string',
            'particulars.*' => 'required|string',
            'start_time.*' => 'required|date_format:H:i',
            'end_time.*' => 'required|date_format:H:i|after:start_time.*',
        ]);

        // Loop through each task and save it
        for ($i = 0; $i < $request->quantity; $i++) {
            $report = new AccomplishmentReport();
            $report->user_id = auth()->id();
            $report->task = $request->task[$i];
            $report->particulars = $request->particulars[$i];
            $report->start_time = $request->start_time[$i];
            $report->end_time = $request->end_time[$i];
            $report->hours = $this->calculateHours($request->start_time[$i], $request->end_time[$i]);
            $report->save();
        }

        return redirect()->route('reports.index')->with('success', 'Reports created successfully.');
    }

    private function calculateHours($start, $end)
    {
        $startTime = new \DateTime($start);
        $endTime = new \DateTime($end);
        $interval = $startTime->diff($endTime);

        return $interval->format('%h hours and %i mins');
    }

    public function index()
    {
        $reports = AccomplishmentReport::where('user_id', auth()->id())->get();
        return view('reports.index', compact('reports'));
    }
}
