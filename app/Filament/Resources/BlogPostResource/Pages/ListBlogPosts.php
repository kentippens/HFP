<?php

namespace App\Filament\Resources\BlogPostResource\Pages;

use App\Filament\Resources\BlogPostResource;
use App\Filament\Exports\BlogPostExporter;
use App\Filament\Imports\BlogPostImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\Action;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Filament\Notifications\Notification;
use App\Services\MarkdownBlogImportService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class ListBlogPosts extends ListRecords
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(BlogPostImporter::class)
                ->label('Import CSV')
                ->color('gray')
                ->icon('heroicon-o-arrow-up-tray'),
            Action::make('importMarkdown')
                ->label('Import Markdown')
                ->color('info')
                ->icon('heroicon-o-document-text')
                ->form([
                    Forms\Components\FileUpload::make('files')
                        ->label('Markdown Files')
                        ->acceptedFileTypes(['text/markdown', 'text/x-markdown', 'text/plain'])
                        ->multiple()
                        ->directory('temp-markdown-imports')
                        ->preserveFilenames()
                        ->required()
                        ->helperText('Upload one or more .md files with YAML frontmatter'),
                    Forms\Components\Placeholder::make('templates')
                        ->label('Download Templates & Documentation')
                        ->content(new HtmlString('
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">Need help? Download our templates and guides:</p>
                                <div class="flex flex-col space-y-1">
                                    <a href="/blog-post-markdown-template.md" download class="text-sm text-primary-600 hover:text-primary-500">
                                        📄 Complete Template (with all options)
                                    </a>
                                    <a href="/blog-post-markdown-minimal.md" download class="text-sm text-primary-600 hover:text-primary-500">
                                        📝 Simple Template (minimal example)
                                    </a>
                                    <a href="/BLOG_IMPORT_GUIDE.md" download class="text-sm text-primary-600 hover:text-primary-500">
                                        📚 Import Guide (full documentation)
                                    </a>
                                </div>
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-700">Quick Format Example:</p>
                                    <pre class="text-xs mt-2 text-gray-600">---
title: "Your Post Title"
category: Pool Care
tags: maintenance, tips
published: true
---

# Your markdown content here...</pre>
                                </div>
                            </div>
                        ')),
                ])
                ->action(function (array $data): void {
                    $importer = new MarkdownBlogImportService();
                    $successful = 0;
                    $failed = 0;
                    $errors = [];

                    foreach ($data['files'] as $file) {
                        $path = Storage::disk('local')->path($file);

                        $result = $importer->importFile($path);

                        if ($result['success']) {
                            $successful++;
                        } else {
                            $failed++;
                            $errors[] = basename($file) . ': ' . $result['error'];
                        }

                        // Clean up temp file
                        Storage::disk('local')->delete($file);
                    }

                    if ($successful > 0) {
                        Notification::make()
                            ->title('Markdown Import Successful')
                            ->body("Imported {$successful} blog post(s) from markdown files.")
                            ->success()
                            ->send();
                    }

                    if ($failed > 0) {
                        Notification::make()
                            ->title('Some imports failed')
                            ->body("Failed to import {$failed} file(s): " . implode(', ', $errors))
                            ->warning()
                            ->send();
                    }
                }),
            ExportAction::make()
                ->exporter(BlogPostExporter::class)
                ->formats([
                    ExportFormat::Csv,
                ])
                ->fileName(fn () => 'blog-posts-export-' . date('Y-m-d-His'))
                ->label('Export Posts')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray'),
        ];
    }
}
