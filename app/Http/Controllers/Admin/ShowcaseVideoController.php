<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShowcaseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShowcaseVideoController extends Controller
{
    public function index()
    {
        $videos = ShowcaseVideo::orderBy('order')->latest()->get();
        return view('admin.showcase-videos.index', compact('videos'));
    }

    public function create()
    {
        $video = new ShowcaseVideo();
        $action = route('admin.showcase-videos.store');
        $method = 'POST';
        return view('admin.showcase-videos.form', compact('video', 'action', 'method'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_file' => 'required|file|mimes:mp4,mov,ogg,qt|max:50000',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/showcase-videos'), $filename);
            $validated['video_path'] = 'uploads/showcase-videos/' . $filename;
        }

        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/showcase-videos'), $filename);
            $validated['thumbnail_path'] = 'showcase-videos/' . $filename;
        }

        ShowcaseVideo::create($validated);

        return redirect()->route('admin.showcase-videos.index')->with('status', 'Video added successfully!');
    }

    public function edit(ShowcaseVideo $showcaseVideo)
    {
        $video = $showcaseVideo;
        $action = route('admin.showcase-videos.update', $video);
        $method = 'PUT';
        return view('admin.showcase-videos.form', compact('video', 'action', 'method'));
    }

    public function update(Request $request, ShowcaseVideo $showcaseVideo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:50000',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('video_file')) {
            if ($showcaseVideo->video_path && file_exists(public_path($showcaseVideo->video_path))) {
                unlink(public_path($showcaseVideo->video_path));
            }
            $file = $request->file('video_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/showcase-videos'), $filename);
            $validated['video_path'] = 'uploads/showcase-videos/' . $filename;
        }

        if ($request->hasFile('thumbnail_file')) {
            if ($showcaseVideo->thumbnail_path && file_exists(public_path('images/' . $showcaseVideo->thumbnail_path))) {
                unlink(public_path('images/' . $showcaseVideo->thumbnail_path));
            }
            $file = $request->file('thumbnail_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/showcase-videos'), $filename);
            $validated['thumbnail_path'] = 'showcase-videos/' . $filename;
        }

        $showcaseVideo->update($validated);

        return redirect()->route('admin.showcase-videos.index')->with('status', 'Video updated successfully!');
    }

    public function destroy(ShowcaseVideo $showcaseVideo)
    {
        if ($showcaseVideo->video_path && file_exists(public_path($showcaseVideo->video_path))) {
            unlink(public_path($showcaseVideo->video_path));
        }
        if ($showcaseVideo->thumbnail_path && file_exists(public_path('images/' . $showcaseVideo->thumbnail_path))) {
            unlink(public_path('images/' . $showcaseVideo->thumbnail_path));
        }
        
        $showcaseVideo->delete();

        return redirect()->route('admin.showcase-videos.index')->with('status', 'Video deleted successfully!');
    }
}
