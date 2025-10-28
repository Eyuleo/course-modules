@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex min-h-[calc(100vh-8rem)] items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <x-card class="w-full max-w-[520px] p-8">
        <h1 class="text-2xl font-semibold mb-6">Create your account</h1>
        <form method="POST" action="{{ url('/register') }}" class="space-y-6">
            @csrf
            <x-input label="Name" name="name" value="{{ old('name') }}" :error="$errors->first('name')" />
            <x-input label="Email" name="email" type="email" value="{{ old('email') }}" :error="$errors->first('email')" />
            <x-select label="Role" name="role" :error="$errors->first('role')">
                <option value="student" @selected(old('role')==='student')>Student</option>
                <option value="client" @selected(old('role')==='client')>Client</option>
            </x-select>
            <x-input label="Password" name="password" type="password" :error="$errors->first('password')" />
            <x-input label="Confirm Password" name="password_confirmation" type="password" />
            <div class="flex items-center justify-between pt-2">
                <x-button type="submit" class="w-auto">Create account</x-button>
                <a href="{{ route('login') }}" class="text-sm text-[#706f6c] hover:text-[#1b1b18]">Have an account? Sign in</a>
            </div>
        </form>
    </x-card>
</div>
@endsection
