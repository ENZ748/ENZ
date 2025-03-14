<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Assignment</title>
</head>
<body>
    <h1>Edit Equipment Assignment</h1>

    <!-- Form to edit accountability -->
    <form action="{{ route('accountability.update', $accountability->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Employee Dropdown -->
        <label for="employee_id">Employee</label>
        <select name="employee_number" id="employee_number">
            <option value="{{ $accountability->employee->employee_number }}" selected>
                {{ $accountability->employee->employee_number }}
            </option>
            @foreach($employees as $employee)
                <option value="{{ $employee->employee_number }}">
                    {{ $employee->employee_number }}
                </option>
            @endforeach
        </select>

        <!-- Equipment Dropdown -->
        <label for="equipment_id">Equipment</label>
        <select name="equipment_name" id="equipment_name">
            <option value="{{ $accountability->equipment->equipment_name }}" selected>
                {{ $accountability->equipment->equipment_name }}
            </option>
            @foreach($equipments as $equipment)
                <option value="{{ $equipment->equipment_name }}">
                    {{ $equipment->equipment_name }}
                </option>
            @endforeach
        </select>

        <!-- Assigned Date -->
        <label for="assigned_date">Assigned Date</label>
        <input type="date" name="assigned_date" id="assigned_date" value="{{ $accountability->assigned_date }}">

        <!-- Return Date -->
        <label for="return_date">Return Data</label>
        <input type="date" name="return_date" id="return_date" value="{{ $accountability->return_date }}">

        <!-- Notes -->
        <label for="notes">Notes</label>
        <input type="text" name="notes" value="{{ $accountability->notes }}">

        <!-- Assigned By -->
        <label for="assigned_by">Assigned By</label>
        <select name="assigned_by">
            <option value="IT" {{ $accountability->assigned_by == 'IT' ? 'selected' : '' }}>IT</option>
            <option value="HR" {{ $accountability->assigned_by == 'HR' ? 'selected' : '' }}>HR</option>
        </select>

        <!-- Submit Button -->
        <button type="submit">Update Assignment</button>
    </form>
</body>
</html>
