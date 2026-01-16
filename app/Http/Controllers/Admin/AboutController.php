<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function edit()
    {
        $about = About::firstOrCreate([], [
            'email' => 'moxer404@aol.com',
            'phone' => '+62 822 6989 8199',
            'location' => 'Padang, Indonesia',
            'availability' => 'Available for freelance & collaboration',
            'timeline' => [],
            'skills' => [],
        ]);

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'required|max:50',
            'location' => 'required|max:255',
            'availability' => 'required|max:255',
            'bio' => 'nullable',
            'timeline' => 'nullable|array',
            'timeline.*.year' => 'nullable|string',
            'timeline.*.title' => 'nullable|string',
            'timeline.*.desc' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);

        // Parse skills from comma-separated string
        if (isset($data['skills'])) {
            $data['skills'] = array_map('trim', explode(',', $data['skills']));
        }

        // Filter empty timeline entries
        if (isset($data['timeline'])) {
            $data['timeline'] = array_filter($data['timeline'], function ($item) {
                return !empty($item['year']) || !empty($item['title']) || !empty($item['desc']);
            });
            $data['timeline'] = array_values($data['timeline']); // reindex
        }

        $about = About::first();
        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        return redirect()->route('admin.about.edit')->with('status', 'About page updated successfully.');
    }
}
