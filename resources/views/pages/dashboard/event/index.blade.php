<x-app-layout>
    <x-slot:title>Data event | </x-slot:title>

    {{-- Breadcrumb --}}
    <nav class="mb-5">
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium text-gray-600" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Event</li>
        </ol>
    </nav>

    {{-- Button add event --}}
    <a href="{{ route('events.create') }}"
        class="z-10 bg-green-700 text-white inline-block px-3 py-3 mb-5 rounded bg-primary text-white-dahsboard">Tambah
        Event</a>


    <table id="search-table">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        Poster
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Event
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Password Event
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Aksi
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td><img src="{{ Storage::url($event->image) }}" alt="" style="width: 100px; height: auto;">
                    </td>
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $event->name }}</td>
                    <td>{{ $event->pass_event }}</td>
                    <td>
                        <a class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            href="{{ route('events.edit', $event->id) }}" type="button">Edit</a>
                        <!-- Tombol untuk membuka modal -->
                        <button data-modal-target="popup-modal-{{ $event->id }}"
                            data-modal-toggle="popup-modal-{{ $event->id }}" type="button"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Hapus</button>

                        <!-- Modal -->
                        <div id="popup-modal-{{ $event->id }}" tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button"
                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                        data-modal-hide="popup-modal-{{ $event->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <svg aria-hidden="true"
                                            class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m2 4h1m0 0v-4m-1 0h-1m2-4V7m-2 0h-1v2h1m0 0V7m0 1v-1">
                                            </path>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah
                                            kamu yakin ingin menghapus event ini?</h3>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-modal-hide="popup-modal-{{ $event->id }}"
                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                Ya, saya yakin
                                            </button>
                                        </form>
                                        <button data-modal-hide="popup-modal-{{ $event->id }}" type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                                            Tidak, batalkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>

</x-app-layout>
