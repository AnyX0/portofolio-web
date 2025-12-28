<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $projects = Project::latest()->take(10)->get();
        $publishedCount = Project::where('is_published', true)->count();
        $draftCount = Project::where('is_published', false)->count();
        $recentCount = Project::where('created_at', '>', now()->subDays(7))->count();

        return view('admin.dashboard', [
            'projects' => $projects,
            'publishedCount' => $publishedCount,
            'draftCount' => $draftCount,
            'recentCount' => $recentCount,
        ]);
    }
}
