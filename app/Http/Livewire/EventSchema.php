<?php

namespace App\Http\Livewire;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;

final class EventSchema
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
                ->native(false)
                ->seconds(false)
                ->required(),
            DateTimePicker::make('end_time')
                ->native(false)
                ->seconds(false)
                ->after('start_time'),
        ];
    }
}
