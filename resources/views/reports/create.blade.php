@extends('layouts.app')

@section('title', 'Create Accomplishment Report')

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
            height: 100vh;
            overflow: hidden; /* Prevent scrolling */
        }

        .container {
            background-color: #ffffff; /* White background for the form */
            padding: 40px;
            border-radius: 15px; /* Rounded edges */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 90%; /* Wider for larger screens */
            max-width: 800px; /* Max width for readability */
            transition: transform 0.3s; /* Animation on hover */
            text-align: left; /* Align text to the left */
            overflow-y: auto; /* Allow scrolling if content overflows */
            height: 90%; /* Full height */
            display: flex; /* Flex to allow full height layout */
            flex-direction: column; /* Vertical alignment of form elements */
            background-color: #fefefe; /* Slightly off-white background for the container */
        }

        h1 {
    color: #ff6f20; /* Vibrant orange */
    margin-top: 40px; /* Increased top margin for elevation */
    margin-bottom: 40px; /* Increased bottom margin for spacing below */
    font-size: 36px; /* Increased font size for stronger presence */
    font-weight: bold; /* Bold text */
    text-align: center; /* Center align the title */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Adds depth to the text */
}


        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
            text-align: left;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none; /* No border */
            border-radius: 25px; /* Rounded edges */
            background-color: #e9f5ff; /* Light blue background for text inputs */
            font-size: 14px;
            height: 45px; /* Consistent height */
            box-sizing: border-box;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        input:focus,
        textarea:focus {
            background-color: #fff; /* White background on focus */
            border: 2px solid #ff6f20; /* Vibrant border on focus */
            outline: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Stronger shadow on focus */
        }

        button {
            background-color: #ff6f20; /* Vibrant orange */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 25px; /* Rounded button */
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            height: 45px; /* Consistent height */
            transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
        }

        button:hover {
            background-color: #e65c00; /* Darker orange on hover */
            transform: translateY(-2px); /* Slight lift effect */
        }

        .task-group {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd; /* Light border around each task */
            border-radius: 10px; /* Rounded corners */
            background-color: #f9f9f9; /* Light gray background for tasks */
        }

        .alert {
            background-color: #d4edda; /* Light green background */
            color: #155724; /* Dark green text */
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb; /* Light green border */
            border-radius: 5px; /* Rounded edges */
            text-align: center; /* Center the text */
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px; /* Less padding on small screens */
                width: 90%; /* Responsive design */
            }
        }
    </style>

    <div class="container">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <h1>Create Accomplishment Report</h1>
        <form action="{{ route('reports.store') }}" method="POST">
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
                <label>Date <i class="fas fa-calendar-alt"></i></label>
                <input type="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label>Number of Tasks</label>
                <input type="number" id="quantity" name="quantity" class="form-control" min="0" value="0" required>
            </div>

            <div id="task-fields"></div>

            <div class="form-group">
                <label>Total Hours</label>
                <input type="text" id="total_hours" class="form-control" readonly>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity');
            const taskFieldsContainer = document.getElementById('task-fields');
            const totalHoursInput = document.getElementById('total_hours');

            // Function to update task fields based on quantity
            quantityInput.addEventListener('input', function () {
                const quantity = parseInt(this.value);
                taskFieldsContainer.innerHTML = ''; // Clear existing fields
                if (quantity > 0) {
                    for (let i = 0; i < quantity; i++) {
                        const taskField = `
                            <div class="task-group">
                                <h1 style="margin: 0; font-size: 18px; color: #ff6f20;">Task ${i + 1}</h4>
                                <div class="form-group">
                                    <label>Task</label>
                                    <input type="text" name="task[]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Particulars</label>
                                    <textarea name="particulars[]" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time[]" class="form-control start_time" required>
                                </div>
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time[]" class="form-control end_time" required>
                                </div>
                            </div>
                        `;
                        taskFieldsContainer.insertAdjacentHTML('beforeend', taskField);
                    }
                }
                calculateTotalHours();
            });

            // Function to calculate total hours
            function calculateTotalHours() {
                const startTimes = document.querySelectorAll('.start_time');
                const endTimes = document.querySelectorAll('.end_time');
                let totalMinutes = 0;

                startTimes.forEach((startTime, index) => {
                    const endTime = endTimes[index];
                    if (startTime.value && endTime.value) {
                        const start = new Date('1970-01-01T' + startTime.value + ':00Z');
                        const end = new Date('1970-01-01T' + endTime.value + ':00Z');
                        totalMinutes += (end - start) / 60000; // Convert milliseconds to minutes
                    }
                });

                const hours = Math.floor(totalMinutes / 60);
                const minutes = totalMinutes % 60;
                totalHoursInput.value = `${hours} hour${hours !== 1 ? 's' : ''} and ${minutes} min${minutes !== 1 ? 's' : ''}`;
            }

            // Event listeners for time changes
            taskFieldsContainer.addEventListener('change', function (e) {
                if (e.target.matches('.start_time') || e.target.matches('.end_time')) {
                    calculateTotalHours();
                }
            });
        });
    </script>
@endsection
