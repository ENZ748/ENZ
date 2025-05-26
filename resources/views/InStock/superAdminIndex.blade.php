@extends('layouts.superAdminApp')

@section('content')

<h1 class="mb-4">In Stock</h1>

<!-- Search Bar -->
<div class="card-body">
        <div class="d-flex justify-content-end">
            <form action="{{ route('superAdmin.instock') }}" method="GET">
                <div class="input-group mb-3" style="width: 450px;">
                    <input type="text" 
                           name="search" 
                           class="form-control border-0" 
                           placeholder="Search by employee name, item, serial number..." 
                           value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>Search
                        </button>
                    </div>
                    @if(request('search'))
                        <div class="input-group-append">
                            <a href="{{ route('superAdmin.instock') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>


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