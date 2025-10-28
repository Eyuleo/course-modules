<nav class="h-16 flex items-center justify-between">
    <div class="flex items-center gap-6">
        <a href="{{ url('/') }}" class="font-semibold text-[#1b1b18]">{{ config('app.name', 'App') }}</a>
        <a href="{{ url('/listings') }}" class="text-[#706f6c] hover:text-[#1b1b18]">Listings</a>
        @auth
            @if(auth()->user()->hasRole('student'))
                <a href="{{ url('/listings/create') }}" class="text-[#706f6c] hover:text-[#1b1b18]">Create listing</a>
            @endif
        @endauth
    </div>
    <div class="flex items-center gap-3">
        @auth
            <a href="{{ url('/orders') }}" class="text-[#706f6c] hover:text-[#1b1b18]">Orders</a>
            <a href="{{ url('/threads') }}" class="text-[#706f6c] hover:text-[#1b1b18]">Messages</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-button type="submit" variant="outline">Logout</x-button>
            </form>
        @else
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="text-[#706f6c] hover:text-[#1b1b18]">Log in</a>
            @endif
            @if (Route::has('register'))
                <x-button as="a" href="{{ route('register') }}">Register</x-button>
            @endif
        @endauth
    </div>
</nav>
