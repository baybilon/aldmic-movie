@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center min-h-[calc(100vh_-_150px)]">
    <div class="w-full max-w-md rounded-xl border border-slate-100 bg-slate-50 p-10 shadow-2xl">

        <div class="mb-8 text-center">
            <h3 class="text-2xl font-bold  text-gray-800 tracking-tight">User Login</h3>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-sm text-red-700 p-4 rounded mb-6 flex items-center shadow-sm">
                <span class="font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            {{ csrf_field() }}
            
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Username</label>
                <input type="text" name="username" 
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition duration-200 outline-none focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10 placeholder-gray-400" 
                    placeholder="Enter your username"
                    required />
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" 
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition duration-200 outline-none focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10 placeholder-gray-400" 
                    placeholder="••••••••"
                    required />
            </div>

            <div class="pt-2">
                <button type="submit" 
                    class="w-full rounded-lg bg-slate-600 px-4 py-3 font-bold text-white shadow-lg transition duration-300 hover:bg-slate-700 hover:shadow-slate-500/30 active:scale-[0.98]">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</div>
@endsection