@extends('layouts.app')

@section('title', 'System Error Check')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">System Error Check</h1>
    
    <!-- PHP Version and Extensions -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h3>PHP Information</h3>
        </div>
        <div class="card-body">
            <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
            <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
            <p><strong>Environment:</strong> {{ config('app.env') }}</p>
            <p><strong>Debug Mode:</strong> {{ config('app.debug') ? 'Enabled' : 'Disabled' }}</p>
        </div>
    </div>

    <!-- Database Connection -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h3>Database Connection</h3>
        </div>
        <div class="card-body">
            @php
                try {
                    DB::connection()->getPdo();
                    $dbStatus = 'Connected';
                    $dbClass = 'text-success';
                } catch (\Exception $e) {
                    $dbStatus = 'Failed: ' . $e->getMessage();
                    $dbClass = 'text-danger';
                }
            @endphp
            <p class="{{ $dbClass }}"><strong>Status:</strong> {{ $dbStatus }}</p>
            @if($dbStatus === 'Connected')
                <p><strong>Database:</strong> {{ config('database.connections.mysql.database') }}</p>
                <p><strong>Services Count:</strong> {{ \App\Models\Service::count() }}</p>
            @endif
        </div>
    </div>

    <!-- Service Images Check -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h3>Service Images Status</h3>
        </div>
        <div class="card-body">
            @php
                $services = \App\Models\Service::all();
            @endphp
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Homepage Image</th>
                        <th>Main Image</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>
                            @if($service->homepage_image)
                                @php
                                    $homepagePath = str_starts_with($service->homepage_image, 'html-pool-delete/') 
                                        ? public_path($service->homepage_image)
                                        : public_path('images/' . $service->homepage_image);
                                    $homepageExists = file_exists($homepagePath);
                                @endphp
                                <span class="{{ $homepageExists ? 'text-success' : 'text-danger' }}">
                                    {{ $homepageExists ? '✓' : '✗' }} {{ $service->homepage_image }}
                                </span>
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>
                        <td>
                            @if($service->image)
                                @php
                                    $imagePath = public_path('images/' . $service->image);
                                    $imageExists = file_exists($imagePath);
                                @endphp
                                <span class="{{ $imageExists ? 'text-success' : 'text-danger' }}">
                                    {{ $imageExists ? '✓' : '✗' }} {{ $service->image }}
                                </span>
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>
                        <td>
                            @php
                                try {
                                    $url = $service->homepage_image_url;
                                    $status = 'OK';
                                    $statusClass = 'text-success';
                                } catch (\Exception $e) {
                                    $status = 'Error';
                                    $statusClass = 'text-danger';
                                }
                            @endphp
                            <span class="{{ $statusClass }}">{{ $status }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Storage Links -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h3>Storage Links</h3>
        </div>
        <div class="card-body">
            @php
                $storageLink = public_path('storage');
                $storageLinkExists = is_link($storageLink);
                $htmlPoolLink = public_path('html-pool-delete');
                $htmlPoolExists = file_exists($htmlPoolLink);
            @endphp
            <p class="{{ $storageLinkExists ? 'text-success' : 'text-danger' }}">
                <strong>Storage Link:</strong> {{ $storageLinkExists ? 'Exists' : 'Missing - Run: php artisan storage:link' }}
            </p>
            <p class="{{ $htmlPoolExists ? 'text-success' : 'text-danger' }}">
                <strong>HTML Pool Delete:</strong> {{ $htmlPoolExists ? 'Exists' : 'Missing' }}
            </p>
        </div>
    </div>

    <!-- Recent Logs -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h3>Recent Error Logs</h3>
        </div>
        <div class="card-body">
            @php
                $logFile = storage_path('logs/laravel.log');
                $recentErrors = [];
                if (file_exists($logFile)) {
                    $lines = array_slice(file($logFile), -20);
                    foreach ($lines as $line) {
                        if (stripos($line, 'error') !== false || stripos($line, 'exception') !== false) {
                            $recentErrors[] = $line;
                        }
                    }
                }
            @endphp
            @if(count($recentErrors) > 0)
                <pre class="bg-light p-2" style="max-height: 300px; overflow-y: auto;">{{ implode('', array_slice($recentErrors, -5)) }}</pre>
            @else
                <p class="text-success">No recent errors found</p>
            @endif
        </div>
    </div>

    <!-- Routes Test -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h3>Routes Test</h3>
        </div>
        <div class="card-body">
            @php
                $routes = [
                    'home' => route('home'),
                    'services.index' => route('services.index'),
                    'contact.index' => route('contact.index'),
                ];
            @endphp
            <ul class="list-unstyled">
                @foreach($routes as $name => $url)
                    <li class="text-success">✓ {{ $name }}: {{ $url }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection