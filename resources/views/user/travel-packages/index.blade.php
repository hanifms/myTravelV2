<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Travel Packages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($travelPackages as $travelPackage)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $travelPackage->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($travelPackage->description, 100) }}</p>

                            <div class="flex justify-between mb-4">
                                <span class="inline-block bg-blue-100 text-blue-800 rounded-full px-3 py-1 text-sm font-semibold">
                                    {{ $travelPackage->destination }}
                                </span>
                                <span class="text-gray-700 font-bold">${{ number_format($travelPackage->price, 2) }}</span>
                            </div>

                            <div class="flex justify-between mb-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-semibold">Start:</span> {{ $travelPackage->start_date->format('M d, Y') }}
                                </div>
                                <div>
                                    <span class="font-semibold">End:</span> {{ $travelPackage->end_date->format('M d, Y') }}
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm {{ $travelPackage->available_slots > 5 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $travelPackage->available_slots }} slots available
                                </span>
                                <a href="{{ route('travel-packages.show', $travelPackage) }}"
                                   class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
