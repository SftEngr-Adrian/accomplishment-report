@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f6f9; /* Light, neutral background */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #2d3436; /* Soft, professional grey */
        }

        h1 {
            color: #2d3436;
            margin: 20px 0;
            font-size: 34px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            text-align: center;
        }

        .filter-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px 0;
            gap: 15px;
        }

        .filter, #searchInput {
            padding: 12px 16px;
            border: 1px solid #dfe6e9;
            border-radius: 30px;
            background-color: #ffffff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.2s ease-in-out;
        }

        .filter:focus, #searchInput:focus {
            border-color: #0984e3;
            box-shadow: 0 0 8px rgba(9, 132, 227, 0.3);
        }

        #searchInput {
            width: 100%;
            max-width: 450px;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            border-collapse: separate;
            border-spacing: 0 10px; /* Adds spacing between rows */
            margin: 20px 0;
            background-color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #74b9ff;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
        }

        tr {
            background-color: #ffffff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }

        tr:hover {
            background-color: #f1f2f6;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-modern {
            background-color: #0984e3;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-modern:hover {
            background-color: #74b9ff;
            transform: scale(1.05);
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 28px;
            }

            table {
                width: 100%;
            }

            .filter {
                width: calc(100% - 20px);
            }
        }
    </style>

    <h1>Accomplishment Reports</h1>

    <div class="filter-container">
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
        
        <select id="accountFilter" class="filter" onchange="filterTable()">
            <option value="">Filter by Account</option>
            <option value="NMPC">NMPC</option>
            <option value="Fast Cargo">Fast Cargo</option>
            <option value="GNP">GNP</option>
            <option value="Others">Others</option>
        </select>

        <select id="taskFilter" class="filter" onchange="filterTable()">
            <option value="">Filter by Task</option>
            <option value="Task NMPC 1">Task NMPC 1</option>
            <option value="Task NMPC 2">Task NMPC 2</option>
            <option value="Task NMPC 3">Task NMPC 3</option>
        </select>

        <select id="particularsFilter" class="filter" onchange="filterTable()">
            <option value="">Filter by Particulars</option>
            <option value="Completed project">Completed project</option>
            <option value="Client meeting">Client meeting</option>
            <option value="Training session">Training session</option>
            <option value="Research work">Research work</option>
        </select>
    </div>

    @if ($reports->isEmpty())
        <p>No accomplishment reports found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Account</th>
                    <th>Task</th>
                    <th>Particulars</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="reportTableBody">
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->account }}</td>
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

    <script>
        function searchTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.getElementById('reportTableBody').getElementsByTagName('tr');

            for (let row of rows) {
                const cells = row.getElementsByTagName('td');
                let match = false;
                for (let cell of cells) {
                    if (cell.textContent.toLowerCase().includes(input)) {
                        match = true;
                        break;
                    }
                }
                row.style.display = match ? '' : 'none';
            }
        }

        function filterTable() {
            const accountFilter = document.getElementById('accountFilter').value.toLowerCase();
            const taskFilter = document.getElementById('taskFilter').value.toLowerCase();
            const particularsFilter = document.getElementById('particularsFilter').value.toLowerCase();
            const rows = document.getElementById('reportTableBody').getElementsByTagName('tr');

            for (let row of rows) {
                const cells = row.getElementsByTagName('td');
                const account = cells[0].textContent.toLowerCase();
                const task = cells[1].textContent.toLowerCase();
                const particulars = cells[2].textContent.toLowerCase();

                const show = (!accountFilter || account.includes(accountFilter)) &&
                             (!taskFilter || task.includes(taskFilter)) &&
                             (!particularsFilter || particulars.includes(particularsFilter));

                row.style.display = show ? '' : 'none';
            }
        }
    </script>
@endsection
