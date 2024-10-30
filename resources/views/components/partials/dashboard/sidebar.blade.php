<div id="sidebar"
    class="bg-gray-800 text-white flex flex-col w-64 space-y-6 absolute inset-y-0 left-0 transform -translate-x-full transition duration-200 ease-in-out md:relative md:translate-x-0 md:flex">

    <!-- Header di Sidebar untuk Mobile: Nama Aplikasi + Tombol X -->
    <div class="flex justify-between items-center p-6">
        <!-- Nama Aplikasi tanpa logo -->
        <span class="text-xl font-semibold">{{ config('app.name', 'Laravel') }}</span>

        <!-- Tombol X (Close Sidebar Button) untuk Mobile -->
        <button id="close-sidebar" class="text-white focus:outline-none md:hidden">
            <!-- Icon X to close the sidebar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Menu Sidebar -->
    <nav class="flex-1 px-4">
        <ul class="space-y-4">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="block py-2 px-4 rounded-md {{ request()->routeIs('dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('events.index') }}"
                    class="block py-2 px-4 rounded-md {{ request()->routeIs('events.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    Produk
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('users.index') }}"
                    class="block py-2 px-4 rounded-md {{ request()->routeIs('users.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    User
                </a>
            </li> --}}
        </ul>
    </nav>


    <!-- Logout Button -->
    <div class="p-4 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md w-full">
                Logout
            </button>
        </form>
    </div>
</div>
