<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Photo;
use App\Http\Requests\CreateEventRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['user', 'photos'])->get();
        return view('pages.dashboard.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create event
            $event = $this->createEvent($request);

            // Store and process images
            $this->storeImages($request, $event);

            DB::commit();
            Alert::toast('Sukses Menambahkan Event', 'success');
            return redirect()->route('events.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal Menambahkan Event: ' . $e->getMessage()]);
        }
    }

    protected function createEvent($request)
    {
        $thumbnail = $request->file("thumbnail");
        $path = $thumbnail->storePublicly("thumbnail", "public");

        return Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $path,
            'pass_event' => $request->pass_event,
            'slug' => Str::slug($request->name . '-' . Str::ulid()),
            'user_id' => Auth::user()->id,
        ]);
    }

    protected function storeImages($request, $event)
    {
        $images = $request->file("images");

        foreach ($images as $image) {
            // Store image
            $path = $image->storePublicly("photos", "public");

            // Get face encodings from Python service
            $response = Http::attach(
                'image',
                file_get_contents($image->path()),
                'image.jpg'
            )->post('http://localhost:5000/detect_faces');

            if ($response->successful()) {
                Photo::create([
                    'event_id' => $event->id,
                    'file_path' => $path,
                    'face_encodings' => $response->json('face_encodings')
                ]);
            } else {
                // Log error but continue processing other images
                Log::error('Face detection failed for image: ' . $path);
                Photo::create([
                    'event_id' => $event->id,
                    'file_path' => $path
                ]);
            }
        }
    }

    public function searchPhotos(Request $request, Event $event)
    {
        try {
            $request->validate([
                'search_image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
                'pass_event' => 'required|string'
            ]);

            // Verify event pass
            if ($event->pass_event !== $request->pass_event) {
                return back()->withErrors(['error' => 'Invalid event pass']);
            }

            // Log untuk debugging
            Log::info('Starting face search for event: ' . $event->id);

            // Send search image to Python service
            $response = Http::attach(
                'image',
                file_get_contents($request->file('search_image')->path()),
                'search.jpg'
            )->post('http://localhost:5000/search_faces', [
                'event_id' => $event->id
            ]);

            Log::info('Python service response:', ['response' => $response->json()]);

            if ($response->successful()) {
                $results = $response->json();

                // Backwards compatibility - check both old and new response format
                if (isset($results['matching_photos'])) {
                    // Old format
                    $photos = Photo::whereIn('id', $results['matching_photos'])
                        ->where('event_id', $event->id)
                        ->get();

                    return view('layouts.search-results', compact('photos', 'event'));
                } elseif (isset($results['face_matches']) && !empty($results['face_matches'])) {
                    // New format - with multiple faces
                    $allPhotoIds = collect($results['face_matches'])
                        ->pluck('matching_photos')
                        ->flatten()
                        ->unique()
                        ->values()
                        ->all();

                    Log::info('Found photo IDs:', ['photos' => $allPhotoIds]);

                    $photos = Photo::whereIn('id', $allPhotoIds)
                        ->where('event_id', $event->id)
                        ->get();

                    $photosByFace = [];
                    foreach ($results['face_matches'] as $index => $faceMatch) {
                        $facePhotos = $photos->whereIn('id', $faceMatch['matching_photos']);
                        $photosByFace[$index] = $facePhotos;
                    }

                    return view('layouts.search-results', compact('photos', 'photosByFace', 'event'));
                }

                return back()->withErrors(['error' => 'No matching faces found']);
            }

            return back()->withErrors(['error' => 'Face recognition failed: ' . ($response->json()['error'] ?? 'Unknown error')]);
        } catch (\Exception $e) {
            Log::error('Error in searchPhotos:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Error during search: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
