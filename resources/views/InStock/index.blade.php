@extends('layouts.app')

@section('content')

<h1 class="mb-4">In Stock</h1>

<div id="table-view" class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($in_stocks as $in_stock)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="font-weight-bold">{{ $in_stock->employee->first_name }} {{ $in_stock->employee->last_name }}</div>
                                        <small class="text-muted">{{ $in_stock->employee->department ?? 'N/A' }}</small>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $in_stock->employee->employee_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <div class="font-weight-bold">{{ $in_stock->item->category->category_name }}</div>
                                        <div class="text-muted small">
                                            {{ $in_stock->item->brand->brand_name }} • {{ $in_stock->item->unit->unit_name }}
                                        </div>
                                    </td>
                                
                                 
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;">{{ $in_stock->item->serial_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;">{{ $in_stock->quantity }}</td>


                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <span class="badge badge-success text-dark">Active</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" class="text-right">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('assigned_items.edit', $in_stock->id) }}" 
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" data-toggle="modal" 
                                                    data-target="#returnModal" 
                                                    data-id="{{ $in_stock->id }}" 
                                                    data-good="{{ route('assigned_items.good', $in_stock->id) }}" 
                                                    data-damaged="{{ route('assigned_items.damaged', $in_stock->id) }}"
                                                    title="Return">
                                                <i class="fas fa-undo"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">No assigned items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
@endsection