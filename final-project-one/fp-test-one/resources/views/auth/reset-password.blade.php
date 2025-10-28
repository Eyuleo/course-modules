@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="flex min-h-[calc(100vh-8rem)] items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <x-card class="w-full max-w-[480px] p-8">
        <h1 class="text-2xl font-semibold mb-6">Reset your password</h1>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <x-input label="Email" name="email" type="email" value="{{ old('email', $email) }}" :error="$errors->first('email')" />
            <x-input label="New Password" name="password" type="password" :error="$errors->first('password')" />
            <x-input label="Confirm Password" name="password_confirmation" type="password" />
            <div class="flex items-center justify-between pt-2">
                <x-button type="submit" class="w-auto">Update password</x-button>
                <a href="{{ route('login') }}" class="text-sm text-[#706f6c] hover:text-[#1b1b18]">Back to login</a>
            </div>
        </form>
    </x-card>
</div>
@endsection
