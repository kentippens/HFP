<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ContactSubmission;
use App\Models\Service;
use App\Models\BlogPost;
use App\Models\User;
use App\Services\ActivityLogger;
use Carbon\Carbon;

class ScheduledExportCommand extends Command
{
    protected $signature = 'export:scheduled
                          {model : The model to export (contacts|services|posts|users|all)}
                          {--format=csv : Export format (csv)}
                          {--period=week : Period for data (day|week|month|year|all)}
                          {--email= : Email address to send the export to}
                          {--storage=exports : Storage disk to save exports}';

    protected $description = 'Generate scheduled exports for various data models';

    protected $exportStats = [];

    public function handle()
    {
        $model = $this->argument('model');
        $format = $this->option('format');
        $period = $this->option('period');
        $email = $this->option('email');
        $storageDisk = $this->option('storage');

        $this->info("Starting scheduled export for {$model} ({$period} period)");

        try {
            $exports = [];

            switch ($model) {
                case 'contacts':
                    $exports[] = $this->exportContactSubmissions($period, $format, $storageDisk);
                    break;
                case 'services':
                    $exports[] = $this->exportServices($period, $format, $storageDisk);
                    break;
                case 'posts':
                    $exports[] = $this->exportBlogPosts($period, $format, $storageDisk);
                    break;
                case 'users':
                    $exports[] = $this->exportUsers($period, $format, $storageDisk);
                    break;
                case 'all':
                    $exports[] = $this->exportContactSubmissions($period, $format, $storageDisk);
                    $exports[] = $this->exportServices($period, $format, $storageDisk);
                    $exports[] = $this->exportBlogPosts($period, $format, $storageDisk);
                    $exports[] = $this->exportUsers($period, $format, $storageDisk);
                    break;
                default:
                    $this->error("Invalid model: {$model}");
                    return 1;
            }

            // Filter out null exports (empty datasets)
            $exports = array_filter($exports);

            if (empty($exports)) {
                $this->warn('No data found for export criteria');
                return 0;
            }

            $this->info('Export completed successfully:');
            foreach ($this->exportStats as $stat) {
                $this->line("- {$stat['model']}: {$stat['count']} records exported to {$stat['file']}");
            }

            // Send email if requested
            if ($email) {
                $this->sendExportEmail($email, $exports);
            }

            // Log the scheduled export activity
            ActivityLogger::logCustom('scheduled_export', null, [
                'model' => $model,
                'period' => $period,
                'format' => $format,
                'files_generated' => count($exports),
                'total_records' => array_sum(array_column($this->exportStats, 'count'))
            ]);

            return 0;

        } catch (\Exception $e) {
            $this->error('Export failed: ' . $e->getMessage());
            Log::error('Scheduled export failed', [
                'model' => $model,
                'period' => $period,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    protected function exportContactSubmissions(string $period, string $format, string $storageDisk): ?string
    {
        $query = ContactSubmission::query();
        $query = $this->applyDateFilter($query, $period);

        $data = $query->orderBy('created_at', 'desc')->get();

        if ($data->isEmpty()) {
            $this->line('No contact submissions found for the specified period');
            return null;
        }

        $filename = $this->generateFilename('contact-submissions', $period, $format);
        $this->exportToCsv($data, $filename, $storageDisk, [
            'id', 'created_at', 'name', 'first_name', 'last_name',
            'email', 'phone', 'service', 'message', 'source', 'source_uri',
            'is_read', 'ip_address'
        ]);

        $this->exportStats[] = [
            'model' => 'Contact Submissions',
            'count' => $data->count(),
            'file' => $filename
        ];

        return $filename;
    }

    protected function exportServices(string $period, string $format, string $storageDisk): ?string
    {
        $query = Service::query();

        // For services, period filtering is based on updated_at since they don't get created frequently
        if ($period !== 'all') {
            $query = $this->applyDateFilter($query, $period, 'updated_at');
        }

        $data = $query->orderBy('id')->get();

        if ($data->isEmpty()) {
            $this->line('No services found for the specified period');
            return null;
        }

        $filename = $this->generateFilename('services', $period, $format);
        $this->exportToCsv($data, $filename, $storageDisk, [
            'id', 'name', 'slug', 'description', 'short_description', 'price_range',
            'is_active', 'is_featured', 'sort_order', 'meta_title', 'meta_description',
            'meta_keywords', 'features', 'benefits', 'overview', 'homepage_image',
            'created_at', 'updated_at'
        ]);

        $this->exportStats[] = [
            'model' => 'Services',
            'count' => $data->count(),
            'file' => $filename
        ];

        return $filename;
    }

    protected function exportBlogPosts(string $period, string $format, string $storageDisk): ?string
    {
        $query = BlogPost::with(['author', 'category']);
        $query = $this->applyDateFilter($query, $period, 'published_at');

        $data = $query->orderBy('published_at', 'desc')->get();

        if ($data->isEmpty()) {
            $this->line('No blog posts found for the specified period');
            return null;
        }

        $filename = $this->generateFilename('blog-posts', $period, $format);

        // Transform data for CSV export
        $transformedData = $data->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => strip_tags($post->content),
                'excerpt' => $post->excerpt,
                'author' => $post->author?->name ?? 'Unknown',
                'category' => $post->category?->name ?? 'Uncategorized',
                'tags' => is_array($post->tags) ? implode(', ', $post->tags) : $post->tags,
                'is_published' => $post->is_published ? 'Yes' : 'No',
                'is_featured' => $post->is_featured ? 'Yes' : 'No',
                'published_at' => $post->published_at?->format('Y-m-d H:i:s'),
                'reading_time' => $post->reading_time,
                'view_count' => $post->view_count,
                'featured_image' => $post->featured_image,
                'meta_title' => $post->meta_title,
                'meta_description' => $post->meta_description,
                'meta_keywords' => $post->meta_keywords,
                'sort_order' => $post->sort_order,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        $this->exportArrayToCsv($transformedData->toArray(), $filename, $storageDisk);

        $this->exportStats[] = [
            'model' => 'Blog Posts',
            'count' => $data->count(),
            'file' => $filename
        ];

        return $filename;
    }

    protected function exportUsers(string $period, string $format, string $storageDisk): ?string
    {
        $query = User::with(['roles', 'permissions']);
        $query = $this->applyDateFilter($query, $period);

        $data = $query->orderBy('created_at', 'desc')->get();

        if ($data->isEmpty()) {
            $this->line('No users found for the specified period');
            return null;
        }

        $filename = $this->generateFilename('users', $period, $format);

        // Transform data for CSV export
        $transformedData = $data->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name')->implode(', '),
                'permissions' => $user->permissions->pluck('name')->implode(', '),
                'email_verified_at' => $user->email_verified_at?->format('Y-m-d H:i:s') ?? 'Not verified',
                'last_login_at' => $user->last_login_at?->format('Y-m-d H:i:s') ?? 'Never',
                'login_count' => $user->login_count ?? 0,
                'failed_login_attempts' => $user->failed_login_attempts ?? 0,
                'locked_until' => $user->locked_until?->format('Y-m-d H:i:s') ?? 'Not locked',
                'is_active' => $user->is_active ? 'Yes' : 'No',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        $this->exportArrayToCsv($transformedData->toArray(), $filename, $storageDisk);

        $this->exportStats[] = [
            'model' => 'Users',
            'count' => $data->count(),
            'file' => $filename
        ];

        return $filename;
    }

    protected function applyDateFilter($query, string $period, string $dateColumn = 'created_at')
    {
        $now = Carbon::now();

        switch ($period) {
            case 'day':
                return $query->whereDate($dateColumn, $now->toDateString());
            case 'week':
                return $query->whereBetween($dateColumn, [
                    $now->startOfWeek()->toDateString(),
                    $now->endOfWeek()->toDateString()
                ]);
            case 'month':
                return $query->whereMonth($dateColumn, $now->month)
                           ->whereYear($dateColumn, $now->year);
            case 'year':
                return $query->whereYear($dateColumn, $now->year);
            case 'all':
            default:
                return $query;
        }
    }

    protected function generateFilename(string $model, string $period, string $format): string
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        return "{$model}-{$period}-export-{$timestamp}.{$format}";
    }

    protected function exportToCsv($data, string $filename, string $storageDisk, array $columns)
    {
        $csvData = [];

        // Add headers
        $csvData[] = $columns;

        // Add data rows
        foreach ($data as $item) {
            $row = [];
            foreach ($columns as $column) {
                $value = $item->{$column};

                // Handle special formatting
                if (is_bool($value)) {
                    $value = $value ? 'Yes' : 'No';
                } elseif (is_array($value)) {
                    $value = implode(', ', $value);
                } elseif ($value instanceof Carbon) {
                    $value = $value->format('Y-m-d H:i:s');
                }

                $row[] = $value;
            }
            $csvData[] = $row;
        }

        $this->saveArrayToCsv($csvData, $filename, $storageDisk);
    }

    protected function exportArrayToCsv(array $data, string $filename, string $storageDisk)
    {
        if (empty($data)) {
            return;
        }

        // Get headers from first item
        $headers = array_keys($data[0]);
        $csvData = [$headers];

        // Add data rows
        foreach ($data as $row) {
            $csvData[] = array_values($row);
        }

        $this->saveArrayToCsv($csvData, $filename, $storageDisk);
    }

    protected function saveArrayToCsv(array $data, string $filename, string $storageDisk)
    {
        $output = fopen('php://temp', 'w');

        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        Storage::disk($storageDisk)->put($filename, $csvContent);
    }

    protected function sendExportEmail(string $email, array $files)
    {
        // This would be implemented with a proper email template
        $this->info("Export files would be emailed to: {$email}");
        $this->line('Files: ' . implode(', ', $files));

        // TODO: Implement actual email sending with Mailable class
        // Mail::to($email)->send(new ExportCompletedMail($files, $this->exportStats));
    }
}