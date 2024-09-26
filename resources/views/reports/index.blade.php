@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff8e1; /* Light background for better contrast */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden; /* Prevent scrollbars on body */
        }

        h1 {
            color: #ff6f20; /* Vibrant orange */
            margin: 20px 0; /* Spacing for title */
            font-size: 36px; /* Increased font size for strong presence */
            font-weight: bold; /* Bold text */
            text-align: center; /* Center align the title */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Adds depth to the text */
        }

        table {
            width: 100%; /* Full width */
            border-collapse: collapse; /* Collapse borders */
            margin: 20px 0; /* Space above and below the table */
            background-color: #fefefe; /* Slightly off-white background */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* Light shadow */
            border-radius: 15px; /* Rounded edges */
            overflow: hidden; /* Ensures rounded edges apply to the table */
        }

        th, td {
            padding: 15px; /* Padding for table cells */
            text-align: left; /* Left align text */
            border-bottom: 1px solid #ddd; /* Light border for separation */
        }

        th {
            background-color: #ff6f20; /* Vibrant orange for header */
            color: white; /* White text for contrast */
            font-weight: bold; /* Bold text for header */
        }

        tr:hover {
            background-color: #f5f5f5; /* Light gray on hover */
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 28px; /* Adjust font size for smaller screens */
            }

            table {
                margin: 10px; /* Reduce margin on small screens */
            }
        }
    </style>

    <h1>My Accomplishment Reports</h1>

    @if ($reports->isEmpty())
        <p>No accomplishment reports found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Particulars</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours</th>
                    <th>Date</th>
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
                        <td>{{ $report->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
