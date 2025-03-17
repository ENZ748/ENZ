<!-- resources/views/layouts/sidebar.blade.php -->
<div class="bg-blue-800 text-white h-full w-64 p-4">
    <h2 class="text-lg font-bold mb-4">ENZ</h2>
    <ul>
        <li class="mb-2"><a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a></li>
        <li class="mb-2"><a href="{{ route('inventory') }}" class="block p-2 hover:bg-gray-700 rounded">Inventory</a></li>
        <li class="mb-2"><a href="{{ route('user') }}" class="block p-2 hover:bg-gray-700 rounded">Users</a></li>
        <li class="mb-2"><a href="{{ route('accountability') }}" class="block p-2 hover:bg-gray-700 rounded">Accountability</a></li>
    </ul>
</div>
