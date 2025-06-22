<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Welcome to the Admin Dashboard</h3>
                <p class="mb-4">As an administrator, you can manage:</p>
                <ul class="list-disc pl-5 mb-4">
                    <li>User accounts</li>
                    <li>Travel packages</li>
                    <li>Bookings</li>
                    <li>Reviews</li>
                </ul>
                <p>Use the navigation to access different admin features.</p>
            </div>
        </div>
    </div>
</x-app-layout>
