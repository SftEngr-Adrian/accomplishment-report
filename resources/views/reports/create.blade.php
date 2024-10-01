@extends('layouts.app')

@section('title', 'Create Accomplishment Report')

@section('content')
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: #f4f6f9; /* Light, neutral background */
        color: #2d3436; /* Soft, professional grey */
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .form-container {
        background-color: #ffffff; /* White background for the form */
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 1500px; /* Fixed width for larger screens */
        transition: transform 0.3s;
    }

    .form-container:hover {
        transform: scale(1.02); /* Slightly enlarge on hover */
    }

    h1 {
        color: #2d3436;
        margin-bottom: 20px;
        font-size: 34px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        text-align: center;
        text-shadow: none;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"],
    select {
        width: 100%;
        padding: 12px;
        border: 1px solid #dfe6e9;
        border-radius: 30px;
        background-color: #f7f9fc;
        font-size: 14px;
        transition: all 0.3s;
    }

    input:focus,
    select:focus {
        background-color: #ffffff;
        border-color: #0984e3;
        box-shadow: 0 0 8px rgba(9, 132, 227, 0.3);
        outline: none;
    }

    table {
        width: 90%;
        margin: 20px 0;
        border-collapse: separate;
        border-spacing: 0 10px;
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

    button {
        background-color: #0984e3;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        width: 100%;
        height: 45px;
        transition: background-color 0.3s, transform 0.3s;
        font-weight: bold;
        margin-top: 10px;
    }

    button:hover {
        background-color: #74b9ff;
        transform: scale(1.05);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-container {
            width: 90%; /* Responsive design */
        }

        h1 {
            font-size: 28px;
        }
    }

    @media (max-width: 480px) {
        button {
            font-size: 14px;
        }

        table {
            font-size: 12px;
        }
    }
</style>

    <div class="form-container">
        <h1>Create Accomplishment Report</h1>

        <form action="{{ route('reports.store') }}" method="POST" id="report-form">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" readonly>
            </div>

            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" class="form-control" value="{{ auth()->user()->position }}" readonly>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
            </div>

            <table id="task-table">
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Task</th>
                        <th>Particular</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Hours</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows will be appended here -->
                </tbody>
            </table>

            <button type="button" id="add-row">Add Task</button>

            <div class="form-group">
                <label>Total Hours</label>
                <input type="text" id="total_hours" class="form-control" readonly>
            </div>

            <button type="button" id="submit-btn">Submit</button>
        </form>
    </div>

    <!-- The Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Check the details carefully</h2>
            <table id="confirmation-table">
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Task</th>
                        <th>Particular</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Hours</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button id="confirm-submit">Confirm Submission</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const taskTableBody = document.querySelector('#task-table tbody');
            const totalHoursInput = document.getElementById('total_hours');
            let taskCounter = 0;
    
            // Define the tasks for each account
            const taskOptions = {
                NMPC: ['Task NMPC 1', 'Task NMPC 2', 'Task NMPC 3'],
                'Fast Cargo': ['Task Fast Cargo 1', 'Task Fast Cargo 2', 'Task Fast Cargo 3'],
                GNP: ['Task GNP 1', 'Task GNP 2', 'Task GNP 3'],
                Others: ['Other Task 1', 'Other Task 2']
            };
    
            // Auto-suggestions for particulars
            const particularsSuggestions = ['Completed project', 'Client meeting', 'Training session', 'Research work'];
    
            document.getElementById('add-row').addEventListener('click', function () {
                taskCounter++;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <select name="account[]" class="account-select">
                            <option value="NMPC">NMPC</option>
                            <option value="Fast Cargo">Fast Cargo</option>
                            <option value="GNP">GNP</option>
                            <option value="Others">Others</option>
                        </select>
                    </td>
                    <td>
                        <select name="task[]" class="task-select">
                            <option value="">Select Task</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="particulars[]" class="form-control particular-input" placeholder="Enter Particular">
                        <div class="suggestions" style="display: none; background: #fff; border: 1px solid #ddd; position: absolute;"></div>
                    </td>
                    <td><input type="time" name="start_time[]" class="form-control start-time"></td>
                    <td><input type="time" name="end_time[]" class="form-control end-time"></td>
                    <td><input type="number" name="hours[]" class="form-control" readonly></td>
                    <td><button type="button" class="remove-row">Remove</button></td>
                `;
                taskTableBody.appendChild(row);
    
                // Populate tasks based on selected account
                const accountSelect = row.querySelector('.account-select');
                const taskSelect = row.querySelector('.task-select');
    
                accountSelect.addEventListener('change', function () {
                    const selectedAccount = this.value;
                    taskSelect.innerHTML = ''; // Clear previous tasks
                    if (taskOptions[selectedAccount]) {
                        taskOptions[selectedAccount].forEach(task => {
                            const option = document.createElement('option');
                            option.value = task;
                            option.textContent = task;
                            taskSelect.appendChild(option);
                        });
                    }
                });
    
                // Calculate hours based on start and end times
                const startTimeInput = row.querySelector('.start-time');
                const endTimeInput = row.querySelector('.end-time');
                const hoursInput = row.querySelector('input[name="hours[]"]');
    
                startTimeInput.addEventListener('change', calculateHours);
                endTimeInput.addEventListener('change', calculateHours);
    
                function calculateHours() {
                    const startTime = startTimeInput.value;
                    const endTime = endTimeInput.value;
    
                    if (startTime && endTime) {
                        const start = new Date(`1970-01-01T${startTime}:00`);
                        const end = new Date(`1970-01-01T${endTime}:00`);
                        
                        // Calculate the total hours initially
                        let hours = (end - start) / (1000 * 60 * 60); // Convert milliseconds to hours
    
                        // Check if the time includes lunch break
                        const lunchStart = new Date(`1970-01-01T12:00:00`);
                        const lunchEnd = new Date(`1970-01-01T12:59:59`);
    
                        // Adjust hours if the time overlaps with lunch
                        if (start < lunchEnd && end > lunchStart) {
                            const overlapStart = start < lunchStart ? lunchStart : start;
                            const overlapEnd = end > lunchEnd ? lunchEnd : end;
                            const overlapHours = (overlapEnd - overlapStart) / (1000 * 60 * 60);
                            hours -= overlapHours; // Subtract overlapping hours
                        }
    
                        hoursInput.value = hours >= 0 ? hours.toFixed(2) : 0; // Set hours or 0 if negative
                    } else {
                        hoursInput.value = ''; // Clear hours if start or end time is not set
                    }
    
                    updateTotalHours();
                }
    
                // Auto-suggest for particulars
                const particularInput = row.querySelector('.particular-input');
                const suggestionsDiv = row.querySelector('.suggestions');
    
                particularInput.addEventListener('input', function () {
                    const value = this.value;
                    suggestionsDiv.innerHTML = '';
                    if (value) {
                        const filteredSuggestions = particularsSuggestions.filter(particular => particular.toLowerCase().includes(value.toLowerCase()));
                        filteredSuggestions.forEach(suggestion => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.textContent = suggestion;
                            suggestionItem.style.cursor = 'pointer';
                            suggestionItem.addEventListener('click', function () {
                                particularInput.value = suggestion;
                                suggestionsDiv.innerHTML = '';
                            });
                            suggestionsDiv.appendChild(suggestionItem);
                        });
                        if (filteredSuggestions.length) {
                            suggestionsDiv.style.display = 'block';
                        } else {
                            suggestionsDiv.style.display = 'none';
                        }
                    } else {
                        suggestionsDiv.style.display = 'none';
                    }
                });
    
                // Remove row functionality
                row.querySelector('.remove-row').addEventListener('click', function () {
                    taskTableBody.removeChild(row);
                    updateTotalHours();
                });
    
                // Update total hours whenever a task is added
                updateTotalHours();
            });
    
            function updateTotalHours() {
                let totalHours = 0;
                const hoursInputs = document.querySelectorAll('input[name="hours[]"]');
                hoursInputs.forEach(input => {
                    const hours = parseFloat(input.value) || 0;
                    totalHours += hours;
                });
                totalHoursInput.value = totalHours.toFixed(2); // Show total hours with two decimal places
            }
    
            document.getElementById('submit-btn').addEventListener('click', function () {
                const confirmationModal = document.getElementById('confirmationModal');
                const confirmationTableBody = document.querySelector('#confirmation-table tbody');
                confirmationTableBody.innerHTML = '';
    
                const accountSelects = document.querySelectorAll('.account-select');
                const taskInputs = document.querySelectorAll('.task-select');
                const particularInputs = document.querySelectorAll('input[name="particulars[]"]');
                const startTimeInputs = document.querySelectorAll('input[name="start_time[]"]');
                const endTimeInputs = document.querySelectorAll('input[name="end_time[]"]');
                const hoursInputs = document.querySelectorAll('input[name="hours[]"]');
    
                accountSelects.forEach((select, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${select.value}</td>
                        <td>${taskInputs[index].value}</td>
                        <td>${particularInputs[index].value}</td>
                        <td>${startTimeInputs[index].value}</td>
                        <td>${endTimeInputs[index].value}</td>
                        <td>${hoursInputs[index].value}</td>
                    `;
                    confirmationTableBody.appendChild(row);
                });
    
                confirmationModal.style.display = 'block';
            });
    
            document.getElementById('closeModal').addEventListener('click', function () {
                document.getElementById('confirmationModal').style.display = 'none';
            });
    
            document.getElementById('confirm-submit').addEventListener('click', function () {
                document.getElementById('report-form').submit();
            });
        });
    </script>
    
    
@endsection
