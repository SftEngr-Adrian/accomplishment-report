@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Accomplishment Reports</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Particulars</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->task }}</td>
                        <td>{{ $report->particulars }}</td>
                        <td>{{ $report->start_time }}</td>
                        <td>{{ $report->end_time }}</td>
                        <td>{{ $report->hours }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
