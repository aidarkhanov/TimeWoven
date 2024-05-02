<?php

namespace App\Http\Livewire;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;

final class EventForm
{
    public static function schema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            MarkdownEditor::make('description')
                ->required(),
            DateTimePicker::make('start_time')
                ->seconds(false)
                ->required(),
            DateTimePicker::make('end_time')
                ->seconds(false)
                ->required()
                ->after('start_time'),
        ];
    }
}
