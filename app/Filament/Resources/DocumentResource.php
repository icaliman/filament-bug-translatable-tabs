<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('code', str($state)->slug());
                        }),

                Forms\Components\TextInput::make('code')
                    ->maxLength(255)
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('categories')
                    ->label('Categories')->translateLabel()
                    ->multiple()
                    ->relationship('categories', 'name')
                    ->preload(),

                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->maxFiles(3)
                    ->storeFileNamesIn('attachment_file_names'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
