<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.production.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Photo Distribution Platform</title>
</head>

<body>
    <!-- Navbar Component -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">PhotoDist</h1>
                </div>
                <div class="flex space-x-8">
                    <a href="#" class="inline-flex items-center px-1 pt-1 text-gray-900">Solutions</a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 text-gray-500">Services</a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 text-gray-500">About Us</a>
                </div>
                <div class="flex items-center">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md">Let's Talk</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Professional Photo Distribution Platform</h2>
                    <p class="text-xl text-gray-600 mb-8">We care about delivering your event photos efficiently and
                        securely.</p>
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-md text-lg">Get Started</button>
                </div>
                <div class="md:w-1/2 mt-8 md:mt-0">
                    <img src="https://picsum.photos/500/300?random=1" alt="Event Photography"
                        class="rounded-lg shadow-lg" />
                </div>
            </div>
        </div>
    </div>

    <!-- Event Cards Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-semibold text-gray-900 mb-8">Recent Events</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Modal form untuk setiap event -->
                @forelse ($events as $event)
                    <form action="{{ route('searchPhotos', $event) }}" method="POST" enctype="multipart/form-data"
                        class="bg-white rounded-lg shadow-md overflow-hidden">
                        @csrf
                        <div class="cursor-pointer" onclick="this.closest('form').submit();">
                            <img src="{{ Storage::url($event->image) }}" alt="Event"
                                class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <h4 class="text-lg font-semibold mb-2">{{ $event->name }}</h4>
                                <p class="text-gray-600">15 Nov 2024</p>
                            </div>
                        </div>

                        <!-- Modal untuk mengisi password (hanya ditampilkan jika ada error) -->
                        @if ($errors->has('error'))
                            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
                                    <h3 class="text-lg font-semibold mb-4">Enter Password for {{ $event->name }}</h3>

                                    <!-- Input Password -->
                                    <input type="password" name="pass_event"
                                        class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="Password"
                                        required>

                                    <!-- Input Search Image -->
                                    <input type="file" name="search_image"
                                        class="w-full p-2 border border-gray-300 rounded mb-4" accept="image/*"
                                        required>

                                    <!-- Display error message -->
                                    <p class="text-red-500 mb-2">{{ $errors->first('error') }}</p>

                                    <!-- Action buttons -->
                                    <div class="flex justify-end space-x-4">
                                        <button type="button" onclick="window.history.back();"
                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Submit</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                @empty
                    <p class="font-semibold text-center text-gray-500">Belum ada tempat wisata</p>
                @endforelse
                {{-- end Modal --}}
            </div>
        </div>
    </div>

    <!-- AI Solution Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2">
                    <img src="/api/placeholder/500/500" alt="AI Solution" class="rounded-lg" />
                </div>
                <div class="md:w-1/2 md:pl-12 mt-8 md:mt-0">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">AI-Powered Photo Distribution</h3>
                    <p class="text-gray-600 text-lg mb-6">Our AI system utilizes facial recognition and smart tagging to
                        streamline photo delivery to event participants with high precision.</p>
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-md">Learn More</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Feature Component -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold mb-2">Event Platform</h4>
                        <p class="text-gray-600">Easily manage and distribute thousands of photos from your events with
                            our streamlined platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
