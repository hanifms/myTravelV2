<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-6">Welcome to the Admin Dashboard</h3>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Users Stats -->
                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h2 class="text-gray-600 text-sm">Users</h2>
                                <p class="text-gray-900 text-xl font-semibold">{{ $userCount }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="mt-3 text-sm text-blue-600 hover:text-blue-800 block">View all users →</a>
                    </div>

                    <!-- Travel Packages Stats -->
                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h2 class="text-gray-600 text-sm">Travel Packages</h2>
                                <p class="text-gray-900 text-xl font-semibold">{{ $packageCount }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.travel-packages.index') }}" class="mt-3 text-sm text-green-600 hover:text-green-800 block">Manage packages →</a>
                    </div>

                    <!-- Bookings Stats -->
                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-amber-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-amber-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h2 class="text-gray-600 text-sm">Active Bookings</h2>
                                <p class="text-gray-900 text-xl font-semibold">{{ $activeBookingsCount }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}" class="mt-3 text-sm text-amber-600 hover:text-amber-800 block">Manage bookings →</a>
                    </div>

                    <!-- Reviews Stats -->
                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h2 class="text-gray-600 text-sm">Reviews</h2>
                                <p class="text-gray-900 text-xl font-semibold">{{ $reviewCount }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}?status=completed" class="mt-3 text-sm text-purple-600 hover:text-purple-800 block">View reviews →</a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('admin.travel-packages.create') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-all">
                            <svg class="h-8 w-8 text-green-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <p class="font-medium">Add New Package</p>
                        </a>
                        <a href="{{ route('admin.users.create') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-all">
                            <svg class="h-8 w-8 text-blue-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <p class="font-medium">Add New User</p>
                        </a>
                        <a href="{{ route('admin.bookings.index') }}?status=pending" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-all">
                            <svg class="h-8 w-8 text-amber-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="font-medium">Pending Bookings</p>
                        </a>
                        <a href="{{ route('admin.bookings.index') }}?status=ongoing" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-all">
                            <svg class="h-8 w-8 text-indigo-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-medium">Ongoing Bookings</p>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Recent Bookings</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Package
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $booking->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $booking->travelPackage->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' :
                                                ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                ($booking->status === 'on_hold' ? 'bg-red-100 text-red-800' :
                                                    'bg-blue-100 text-blue-800')) }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $booking->booking_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No recent bookings found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.bookings.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View all bookings →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
