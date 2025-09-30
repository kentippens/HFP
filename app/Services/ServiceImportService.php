<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Str;

class ServiceImportService extends BaseImportService
{
    protected function getModel(): string
    {
        return Service::class;
    }

    public function getValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price_range' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'features' => 'nullable|string',
            'benefits' => 'nullable|string',
            'overview' => 'nullable|string',
            'homepage_image' => 'nullable|string|max:255',
        ];
    }

    protected function transformRow(array $row): array
    {
        // Generate slug if not provided
        if (empty($row['slug']) && !empty($row['name'])) {
            $row['slug'] = Str::slug($row['name']);

            // Ensure slug uniqueness
            $originalSlug = $row['slug'];
            $counter = 1;
            while (Service::where('slug', $row['slug'])->exists()) {
                $row['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Convert string booleans to actual booleans
        $row['is_active'] = $this->convertToBoolean($row['is_active'] ?? true);
        $row['is_featured'] = $this->convertToBoolean($row['is_featured'] ?? false);

        // Convert features and benefits from comma-separated strings to arrays
        if (!empty($row['features'])) {
            $row['features'] = array_map('trim', explode(',', $row['features']));
        }

        if (!empty($row['benefits'])) {
            $row['benefits'] = array_map('trim', explode(',', $row['benefits']));
        }

        // Set default sort_order if not provided
        if (!isset($row['sort_order'])) {
            $row['sort_order'] = Service::max('sort_order') + 1;
        }

        return $row;
    }

    protected function createRecord(array $data): void
    {
        Service::create($data);
    }

    protected function convertToBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = strtolower(trim($value));
            return in_array($value, ['1', 'true', 'yes', 'on', 'active']);
        }

        return (bool) $value;
    }

    protected function getSampleData(): array
    {
        return [
            [
                'name' => 'Pool Resurfacing',
                'slug' => 'pool-resurfacing',
                'description' => 'Complete pool resurfacing service with high-quality materials',
                'short_description' => 'Professional pool resurfacing',
                'price_range' => '$3000-$8000',
                'is_active' => 'Yes',
                'is_featured' => 'Yes',
                'sort_order' => 1,
                'meta_title' => 'Professional Pool Resurfacing Services',
                'meta_description' => 'Expert pool resurfacing services for residential and commercial pools',
                'meta_keywords' => 'pool resurfacing, pool repair, swimming pool',
                'features' => 'Durable materials, Professional installation, 5-year warranty',
                'benefits' => 'Increased property value, Enhanced pool appearance, Long-lasting results',
                'overview' => 'Transform your old pool with our professional resurfacing service',
                'homepage_image' => 'images/services/pool-resurfacing.jpg'
            ],
            [
                'name' => 'Pool Maintenance',
                'slug' => 'pool-maintenance',
                'description' => 'Regular pool maintenance and cleaning service',
                'short_description' => 'Keep your pool clean and healthy',
                'price_range' => '$100-$300/month',
                'is_active' => 'Yes',
                'is_featured' => 'No',
                'sort_order' => 2,
                'meta_title' => 'Pool Maintenance Services',
                'meta_description' => 'Professional pool maintenance and cleaning services',
                'meta_keywords' => 'pool maintenance, pool cleaning, pool service',
                'features' => 'Weekly cleaning, Chemical balancing, Equipment inspection',
                'benefits' => 'Crystal clear water, Extended equipment life, Peace of mind',
                'overview' => 'Regular maintenance keeps your pool in perfect condition',
                'homepage_image' => 'images/services/pool-maintenance.jpg'
            ]
        ];
    }
}