@extends('layouts.app')

@section('content')

<h1>In Stock</h1>

<div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-nowrap">Employee</th>
                                <th class="text-nowrap">Employee #</th>
                                <th class="text-nowrap">Item Details</th>
                                <th class="text-nowrap">Serial #</th>
                                <th>Quantity</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($in_stocks as $in_stock)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $in_stock->employee->first_name }} {{ $in_stock->employee->last_name }}</div>
                                        <small class="text-muted">{{ $in_stock->employee->department ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $in_stock->employee->employee_number }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $in_stock->item->category->category_name }}</div>
                                        <div class="text-muted small">
                                            {{ $in_stock->item->brand->brand_name }} • {{ $in_stock->item->unit->unit_name }}
                                        </div>
                                    </td>
                                
                                 
                                    <td style="color: #212529;">{{ $in_stock->item->serial_number }}</td>
                                    <td style="color: #212529;">{{ $in_stock->quantity }}</td>


                                    <td>
                                        <span class="badge badge-success text-dark">Active</span>
                                    </td>
                                    <td class="text-right">
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
                                    <td colspan="7" class="text-center py-4">No assigned items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
@endsection