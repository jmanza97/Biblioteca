<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('description')
                    ->required(),
                TextInput::make('ISBN')
                    ->label('ISBN')
                    ->required(),
                TextInput::make('total_copies')
                    ->required()
                    ->numeric(),
                TextInput::make('available_copies')
                    ->required()
                    ->numeric(),
                Toggle::make('is_available')
                    ->required(),
            ]);
    }
}
