<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
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
                TextColumn::make('start_time')->dateTime(), // Ensure proper date formatting
                TextColumn::make('end_time')->dateTime(),
            ])
            ->headerActions([
                Action::make('new')
                    ->label(__('New Event'))
                    ->icon('heroicon-o-plus')
                    ->slideOver()
                    ->form(EventForm::schema()),
            ])
            ->actions([
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->slideOver()
                    ->modalHeading('Edit Event')
                    ->form(EventForm::schema())
                    ->fillForm(fn ($record) => [
                        'title' => $record->title,
                        'description' => $record->description,
                        'start_time' => $record->start_time,
                        'end_time' => $record->end_time,
                    ])
                    ->action(fn ($record, $data) => $record->fill($data)->save()),
                Action::make('delete')
                    ->label('Delete')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $this->delete($record->id)),
            ])
            ->bulkActions([
                // Define bulk actions if necessary
            ]);
    }

    public function render(): View
    {
        return view('livewire.event-list')->layoutData(['heading' => 'Events']);
    }

    public function delete($eventId): void
    {
        $event = Event::where('user_id', auth()->id())->findOrFail($eventId);
        $event->delete();
        session()->flash('message', 'Event deleted successfully.');
    }
}
