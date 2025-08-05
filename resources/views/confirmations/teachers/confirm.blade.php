@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container mx-auto py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-6 shadow-sm rounded-md" role="alert">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-xl font-semibold mb-1">Confirm Teacher Account</h4>
                    <p class="text-sm">
                        Please review the details below carefully before confirming this teacher's account. Once confirmed, the teacher will be granted full access to the system.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mt-6">
            <div class="bg-gray-100 px-6 py-4 flex justify-between items-center">
                <h5 class="text-lg font-bold text-gray-800">Teacher Details</h5>
                <svg class="h-6 w-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="p-6">
                @foreach ($teachers as $teacher)
                    <div class="mb-4">
                        <label class="block text-gray-500 text-sm font-medium mb-1">Name</label>
                        <p class="text-gray-800 font-bold">{{ $teacher->name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-500 text-sm font-medium mb-1">Email</label>
                        <p class="text-gray-800 font-bold">{{ $teacher->email }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-500 text-sm font-medium mb-1">Phone</label>
                        <p class="text-gray-800 font-bold">{{ $teacher->phone }}</p>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <div class="flex justify-between items-center">
                        <form method="POST" action="">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white font-bold py-3 px-6 rounded-md hover:bg-green-700 transition duration-300 ease-in-out flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Confirm</span>
                            </button>
                        </form>
                        <a href="#" class="bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-md hover:bg-gray-300 transition duration-300 ease-in-out flex items-center space-x-2">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Cancel</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</main>
@endsection
