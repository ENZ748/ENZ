@extends('layouts.app')

@section('content')

    <h1>Assigned Items History</h1>

    <table class="table mt-3">
        <thead>
            <tr>
                <th style="background-color: #012a4a; color: white;" class="py-3 px-4 text-left">FIRST NAME</th>
                <th style="background-color: #013a63; color: white;" class="py-3 px-4 text-left">LAST NAME</th>
                <th style="background-color: #01497c; color: white;" class="py-3 px-4 text-left">EMPLOYEE NUMBER</th>
                <th style="background-color: #014F86; color: white;" class="py-3 px-4 text-left">ITEM CATEGORY</th>
                <th style="background-color: #2A6F97; color: white;" class="py-3 px-4 text-left">ITEM BRAND</th>
                <th style="background-color: #2C7DA0; color: white;" class="py-3 px-4 text-left">ITEM UNIT</th>
                <th style="background-color: #468FAF; color: white;" class="py-3 px-4 text-left">SERIAL NUMBER</th>
                <th style="background-color: #61A5C2; color: white;" class="py-3 px-4 text-left">ASSIGNED DATE</th>
                <th style="background-color: #89C2D9; color: white;" class="py-3 px-4 text-left">NOTES</th>
                <th style="background-color: #A9D6E5; color: white;" class="py-3 px-4 text-left">RETURNED DATE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignedItems as $assignedItem)
                <tr>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->employee->first_name }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->employee->last_name }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->employee->employee_number }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->item->category->category_name }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->item->brand->brand_name }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->item->unit->unit_name }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->item->serial_number }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->assigned_date }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{ $assignedItem->notes }}</td>
                    <td style="background-color: rgba(109, 174, 219, 0.1);">{{$assignedItem->created_at}}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection
