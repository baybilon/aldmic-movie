@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-96 border border-gray-700">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        
        @if($errors->any())
            <div class="bg-red-500 text-sm p-3 rounded mb-4">{{ $errors->first() }}</div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            {{ csrf_field() }}
            <div class="mb-4">
                <label class="block text-sm mb-2">Username</label>
                <input type="text" name="username" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:border-yellow-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm mb-2">Password</label>
                <input type="password" name="password" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:border-yellow-500" required>
            </div>
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded transition">Login</button>
        </form>
    </div>
</div>
@endsection