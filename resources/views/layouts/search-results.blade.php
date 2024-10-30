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
    <!-- Event Cards Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-semibold text-gray-900 mb-8">{{ $event->name }}</h3>
            {{-- Updated view code --}}
            @if (isset($photosByFace))
                @foreach ($photosByFace as $faceIndex => $facePhotos)
                    <h3>Face {{ $faceIndex + 1 }} Matches ({{ $facePhotos->count() }} photos)</h3>
                    <div class="photo-grid">
                        @foreach ($facePhotos as $photo)
                            <div class="photo-item">
                                <img src="{{ Storage::url($photo->file_path) }}" alt="Matching photo">
                                <div class="confidence">
                                    Match: {{ number_format($photo->confidence, 1) }}%
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <style>
        /* Styling untuk layout ala Pinterest */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin: 20px 0;
        }

        .photo-item {
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .photo-item img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }
    </style>
</body>

</html>
