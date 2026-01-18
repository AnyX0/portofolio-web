<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Project;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('project:ensure {slug} {--title=} {--summary=} {--description=} {--tech_stack=} {--live_url=} {--repo_url=} {--published=1}', function (string $slug) {
    $data = [
        'title' => $this->option('title') ?? $slug,
        'summary' => $this->option('summary') ?? 'Auto-created via project:ensure',
        'description' => $this->option('description'),
        'tech_stack' => $this->option('tech_stack'),
        'live_url' => $this->option('live_url'),
        'repo_url' => $this->option('repo_url'),
        'is_published' => in_array(strtolower((string) $this->option('published')), ['1','true','yes','on'], true),
        'published_at' => null,
    ];

    if ($data['is_published']) {
        $data['published_at'] = now();
    }

    $project = Project::updateOrCreate(['slug' => $slug], array_filter($data, fn($v) => $v !== null));

    $this->info('Project ensured:');
    $this->line(' - ID: '.$project->id);
    $this->line(' - Slug: '.$project->slug);
    $this->line(' - Title: '.$project->title);
    $this->line(' - Live URL: '.($project->live_url ?? '-'));
    $this->line(' - Published: '.($project->is_published ? 'yes' : 'no'));
})->purpose('Create or update a project by slug with optional fields');
