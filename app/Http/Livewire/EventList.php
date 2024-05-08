<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Schema;
use App\Models\Event;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\View\View;
use Livewire\Component;

class EventList extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Event::with('user')->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('description')->limit(45),
                TextColumn::make('start_time')->dateTime(),
                TextColumn::make('end_time')->dateTime(),
            ])
            ->headerActions([
                CreateAction::make('new')
                    ->label(__('New Event'))
                    ->icon('heroicon-o-plus')
                    ->slideOver()
                    ->form(EventSchema::schema())
                    ->mutateFormDataUsing(function ($data) {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->actions([
                EditAction::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->slideOver()
                    ->modalHeading('Edit Event')
                    ->form(EventSchema::schema()),
                DeleteAction::make('delete')
                    ->label('Delete')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.event-list')->layoutData(['heading' => 'Events']);
    }
}
