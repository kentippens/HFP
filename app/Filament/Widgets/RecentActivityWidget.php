<?php

namespace App\Filament\Widgets;

use App\Models\Activity;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'Recent Activity';
    }

    protected function getTableDescription(): ?string
    {
        return 'Latest system activities and user actions';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()
                    ->with(['causer', 'subject'])
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('g:i A')
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at->format('F j, Y g:i A')),

                Tables\Columns\IconColumn::make('event')
                    ->label('')
                    ->getStateUsing(fn ($record) => $record->getIcon())
                    ->color(fn ($record) => $record->getColor()),

                Tables\Columns\TextColumn::make('event')
                    ->label('Action')
                    ->formatStateUsing(fn ($record) => $record->getEventLabel())
                    ->badge()
                    ->color(fn ($record) => $record->getColor()),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->formatStateUsing(fn ($record) => $record->getFormattedDescription())
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->getFormattedDescription()),

                Tables\Columns\TextColumn::make('log_name')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match($state) {
                        'auth' => 'success',
                        'model' => 'info',
                        'contact' => 'warning',
                        'export' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Type')
                    ->options([
                        'auth' => 'Authentication',
                        'model' => 'Model Changes',
                        'contact' => 'Contact Forms',
                        'export' => 'Data Exports',
                    ]),

                Tables\Filters\Filter::make('today')
                    ->label('Today Only')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today()))
                    ->default(),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Activity $record): string =>
                        route('filament.admin.resources.activity-logs.view', $record))
                    ->openUrlInNewTab(),
            ])
            ->striped()
            ->paginated([10, 20])
            ->poll('30s')
            ->emptyStateHeading('No activities yet')
            ->emptyStateDescription('Activities will appear here as users interact with the system')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }
}