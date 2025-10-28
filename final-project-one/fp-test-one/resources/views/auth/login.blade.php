@extends('layouts.app')

@section('title', 'Log in')

@section('content')
<div class="flex min-h-[calc(100vh-8rem)] items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <x-card class="w-full max-w-[480px] p-8">
        <h1 class="text-2xl font-semibold mb-6">Log in</h1>
        <form method="POST" action="{{ url('/login') }}" class="space-y-6">
            @csrf
            <x-input label="Email" name="email" type="email" value="{{ old('email') }}" :error="$errors->first('email')" />
            <x-input label="Password" name="password" type="password" :error="$errors->first('password')" />
            <label class="inline-flex items-center gap-2 text-sm text-[#1b1b18]">
                <input type="checkbox" name="remember" value="1" class="h-3 w-3 rounded-sm border border-[#d9d9d4]">
                Remember me
            </label>
            <div class="flex items-center justify-between pt-2">
                <x-button type="submit" class="w-auto">Sign in</x-button>
                <a href="{{ route('password.request') }}" class="text-sm text-[#706f6c] hover:text-[#1b1b18]">Forgot password?</a>
            </div>
        </form>
    </x-card>
</div>
@endsection
