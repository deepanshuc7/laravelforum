<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Navigation links for all users -->
            {{-- <a href="{{ route('home') }}" class="text-white">Home</a> --}}
           
            @if(auth()->check() && auth()->user()->is_admin)
    <a href="{{ route('admin.home.index') }}" class="text-white">Home</a>
@else
    <a href="{{ route('home') }}" class="text-white">Home</a>
@endif
            @auth
                <a href="{{ route('profile.edit') }}" class="text-white">My Profile</a>
                <a href="{{ route('discussions.create') }}" class="text-white">New Discussion</a>

                <a href="{{ route('messages.index') }}" class="text-white">Messages</a>

                <!-- Admin menu (visible only to admins) -->
                @if(auth()->user()->is_admin)
                    <div class="relative">
                        <button id="adminMenuButton" class="text-white focus:outline-none">
                            Admin
                            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div id="adminMenu" class="hidden absolute right-0 mt-2 bg-gray-800 text-white border border-gray-700 rounded-lg shadow-lg">
                            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 hover:bg-gray-700">Manage Users</a>
                            <a href="{{ route('admin.discussions.index') }}" class="block px-4 py-2 hover:bg-gray-700">Manage Discussions</a>
                            <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 hover:bg-gray-700">Manage Categories</a>
                            <!-- Add more admin links as needed -->
                        </div>
                    </div>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="text-white">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white">Login</a>
                <a href="{{ route('register') }}" class="text-white">Register</a>
            @endauth
        </div>
    </nav>

    <div class="content p-6">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const adminMenuButton = document.getElementById('adminMenuButton');
            const adminMenu = document.getElementById('adminMenu');

            adminMenuButton.addEventListener('click', () => {
                adminMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!adminMenu.contains(event.target) && !adminMenuButton.contains(event.target)) {
                    adminMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
