@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="flex min-h-[calc(100vh-8rem)] items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <x-card class="w-full max-w-[480px] p-8">
        <h1 class="text-2xl font-semibold mb-3">Forgot your password?</h1>
        <p class="text-sm text-[#706f6c] mb-6">Enter your email and we will send you a reset link.</p>
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <x-input label="Email" name="email" type="email" value="{{ old('email') }}" :error="$errors->first('email')" />
            <div class="flex items-center justify-between pt-2">
                <x-button type="submit" class="w-auto">Send reset link</x-button>
                <a href="{{ route('login') }}" class="text-sm text-[#706f6c] hover:text-[#1b1b18]">Back to login</a>
            </div>
        </form>
    </x-card>
</div>
@endsection
