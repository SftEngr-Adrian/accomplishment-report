@extends('layouts.app') 

@section('title', 'Create Accomplishment Report')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
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
                <label>Number of Tasks and Particulars</label>
                <input type="hidden" name="quantity" value="0">
            </div>
            <div id="task-fields"></div>
            <div class="form-group">
                <label>Total Hours</label>
                <input type="text" id="total_hours" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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
                                <h4>Task ${i + 1}</h4>
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
