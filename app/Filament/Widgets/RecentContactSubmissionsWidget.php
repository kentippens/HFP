<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Traits\HandlesWidgetErrors;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentContactSubmissionsWidget extends BaseWidget
{
    use HandlesWidgetErrors;

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'Recent Contact Submissions';
    }

    protected function getTableDescription(): ?string
    {
        return 'Latest submissions requiring attention';
    }

    public function table(Table $table): Table
    {
        return $this->measureOperation('buildTable', function () use ($table) {
            // Use safe query with error handling
            $query = $this->safeQuery(function () {
                return ContactSubmission::query()
                    ->where('is_read', false)
                    ->orderBy('created_at', 'desc')
                    ->limit(10);
            }, null, 0); // No caching for table queries to ensure real-time data

            return $table->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Phone copied')
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('service')
                    ->label('Service')
                    ->limit(30)
                    ->tooltip(function (ContactSubmission $record): ?string {
                        return strlen($record->service) > 30 ? $record->service : null;
                    })
                    ->badge()
                    ->color(fn (string $state): string => match(true) {
                        str_contains($state, 'pool') => 'info',
                        str_contains($state, 'investor') => 'warning',
                        str_contains($state, 'newsletter') => 'success',
                        default => 'gray'
                    }),

                Tables\Columns\TextColumn::make('source')
                    ->label('Source')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', ucfirst($state)))
                    ->color(fn (string $state): string => match($state) {
                        'homepage_form' => 'success',
                        'contact_page' => 'info',
                        'service_form' => 'warning',
                        'investor_relations_page' => 'danger',
                        'newsletter' => 'primary',
                        'pool_quote' => 'info',
                        default => 'gray'
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M j, g:i A')
                    ->sortable()
                    ->since()
                    ->tooltip(fn (ContactSubmission $record): string => $record->created_at->format('F j, Y g:i A')),

                Tables\Columns\IconColumn::make('is_read')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (ContactSubmission $record): string =>
                        route('filament.admin.resources.contact-submissions.edit', $record))
                    ->openUrlInNewTab(),

                Action::make('mark_as_read')
                    ->label('Mark Read')
                    ->icon('heroicon-m-check')
                    ->requiresConfirmation()
                    ->action(function (ContactSubmission $record) {
                        return $this->safeQuery(function () use ($record) {
                            $record->update(['is_read' => true]);
                            // Clear relevant caches after marking as read
                            $this->clearWidgetCache('*unread*');
                            $this->clearWidgetCache('*today*');
                            return true;
                        });
                    })
                    ->visible(fn (ContactSubmission $record): bool => !$record->is_read)
                    ->color('success'),
            ])
                ->striped()
                ->paginated([5, 10])
                ->poll('10s')
                ->emptyStateHeading('No unread submissions')
                ->emptyStateDescription('All contact submissions have been reviewed')
                ->emptyStateIcon('heroicon-o-check-circle');
        });
    }
}