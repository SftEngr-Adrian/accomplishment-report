<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccomplishmentReport;
use Carbon\Carbon;
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
        'account.*' => 'required|string',
        'task.*' => 'required|string',
        'particulars.*' => 'required|string',
        'start_time.*' => 'required|date_format:H:i',
        'end_time.*' => 'required|date_format:H:i|after:start_time.*',
        'date' => 'required|date_format:Y-m-d',
    ]);
    
    // Loop through each task and save it
    $tasksCount = count($request->task);
    $duplicateRecords = []; // Array to store duplicate record messages

    for ($i = 0; $i < $tasksCount; $i++) {
        // Create a unique identifier for the report
        $uniqueIdentifier = [
            'user_id' => auth()->id(),
            'account' => $request->account[$i],
            'task' => $request->task[$i],
            'particulars' => $request->particulars[$i],
            'start_time' => $request->start_time[$i],
            'end_time' => $request->end_time[$i],
            'date' => $request->date,
        ];

        // Check for existing records with the same attributes
        $existingReport = AccomplishmentReport::where($uniqueIdentifier)->first();

        if (!$existingReport) {
            $report = new AccomplishmentReport();
            $report->user_id = auth()->id();
            $report->account = $request->account[$i];
            $report->task = $request->task[$i];
            $report->particulars = $request->particulars[$i];
            $report->start_time = $request->start_time[$i];
            $report->end_time = $request->end_time[$i];
            $report->date = $request->date;

            // Calculate hours only if start_time and end_time are set
            if ($report->start_time && $report->end_time) {
                $hoursData = $this->calculateHours($report->start_time, $report->end_time);
                $report->hours = sprintf('%d hours and %d mins', $hoursData['hours'], $hoursData['minutes']);
            } else {
                $report->hours = null; // Handle case where times are not set
            }

            $report->save();
        } else {
            // Add the duplicate record message to the array
            $duplicateRecords[] = "Duplicate entry for account: {$request->account[$i]}, task: {$request->task[$i]}, particulars: {$request->particulars[$i]}, date: {$request->date}.";
        }
    }

    // Redirect with a success message and duplicate records, if any
    if (count($duplicateRecords) > 0) {
        return redirect()->route('reports.index')->with('success', 'Reports created successfully.')->with('duplicates', $duplicateRecords);
    } else {
        return redirect()->route('reports.index')->with('success', 'Reports created successfully.');
    }
}

private function calculateHours($start, $end)
{
    // Use Carbon to handle time calculations
    $startTime = Carbon::createFromFormat('H:i', $start);
    $endTime = Carbon::createFromFormat('H:i', $end);

    // Set lunch break times (12:00 PM - 12:59 PM)
    $lunchStart = Carbon::createFromTime(12, 0);
    $lunchEnd = Carbon::createFromTime(12, 59);

    // Calculate total hours initially
    $totalInterval = $startTime->diffInMinutes($endTime);

    // Check if the time range overlaps with the lunch break
    if ($startTime < $lunchEnd && $endTime > $lunchStart) {
        // Subtract 1 hour (60 minutes) for lunch break if there is an overlap
        $totalInterval -= 60;
    }

    // Convert total minutes back to hours and minutes
    $adjustedHours = floor($totalInterval / 60);
    $remainingMinutes = $totalInterval % 60;

    // Return total hours and minutes as an array
    return [
        'hours' => $adjustedHours,
        'minutes' => $remainingMinutes,
    ];
}

    public function index()
{
    $reports = AccomplishmentReport::where('user_id', auth()->id())->get()->map(function ($report) {
        // Format the date if it's not null or empty
        if ($report->date) {
            $report->date = Carbon::parse($report->date)->format('F j, Y'); // Format the date
        }
        return $report;
    });

    return view('reports.index', compact('reports'));
}
}
