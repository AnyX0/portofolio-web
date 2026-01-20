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
            'name' => 'Andi Utama',
            'title' => 'Mobile & Web Engineer',
            'email' => 'moxer404@aol.com',
            'phone' => '+62 822 6989 8199',
            'location' => 'Padang, Indonesia',
            'availability' => 'Available for freelance & collaboration',
            'timeline' => [],
            'skills' => [],
        ]);

        // Pastikan field baru memiliki nilai default agar form tidak kosong
        if (!$about->name || !$about->title) {
            $about->fill([
                'name' => $about->name ?: 'Andi Utama',
                'title' => $about->title ?: 'Mobile & Web Engineer',
            ])->save();
        }

        // Normalisasi skills lama (jika sebelumnya berupa array string)
        $about->skills = collect($about->skills ?? [])->map(function ($item) {
            if (is_string($item)) {
                return [
                    'type' => 'Skill',
                    'title' => $item,
                    'detail' => '',
                ];
            }
            return $item;
        })->toArray();

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:50',
            'location' => 'required|max:255',
            'availability' => 'required|max:255',
            'bio' => 'nullable',
            'timeline' => 'nullable|array',
            'timeline.*.year' => 'nullable|string',
            'timeline.*.title' => 'nullable|string',
            'timeline.*.desc' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*.type' => 'nullable|string|max:100',
            'skills.*.title' => 'nullable|string|max:150',
            'skills.*.detail' => 'nullable|string|max:255',
        ]);

        // Filter empty skills entries
        if (isset($data['skills'])) {
            $data['skills'] = array_values(array_filter($data['skills'], function ($item) {
                return !empty($item['type']) || !empty($item['title']) || !empty($item['detail']);
            }));
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
