<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DanceResource\Pages;
use App\Filament\Resources\DanceResource\RelationManagers;
use App\Models\Dance;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DanceResource extends Resource
{
    protected static ?string $model = Dance::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

    public static function getPluralModelLabel(): string
    {
        return 'Data Tarian';
    }

    public static function getLabel(): string
    {
        return 'Data Tarian';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('categories_id')
                    ->label('Kategori')
                    ->relationship('category', 'name') // Pastikan model Dance punya relasi 'category'
                    ->required(),

                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->required(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->required(),

                Textarea::make('origin_region')
                    ->label('Daerah Asal')
                    ->rows(2)
                    ->required(),

                FileUpload::make('attachment1')
                    ->label('Lampiran 1')
                    ->directory('dances/attachments')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(2048)
                    ->required(), // Dalam KB

                FileUpload::make('attachment2')
                    ->label('Lampiran 2')
                    ->directory('dances/attachments')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(2048),

                Toggle::make('is_archived')
                    ->label('Arsipkan?'),

                Select::make('difficulty_level')
                    ->label('Tingkat Kesulitan')
                    ->options([
                        1 => 'Mudah',
                        2 => 'Sedang',
                        3 => 'Sulit',
                    ])
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(30),

                TextColumn::make('origin_region')
                    ->label('Asal')
                    ->limit(20),

                IconColumn::make('is_archived')
                    ->label('Diarsipkan')
                    ->boolean(),

                TextColumn::make('difficulty_level')
                    ->label('Kesulitan')
                    ->formatStateUsing(function (?int $state) {
                        return match ($state) {
                            1 => 'Mudah',
                            2 => 'Sedang',
                            3 => 'Sulit',
                            default => '-',
                        };
                    }),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),
            ])
            ->filters([
                SelectFilter::make('categories_id')
                    ->label('Filter Kategori')
                    ->relationship('category', 'name'),

                SelectFilter::make('difficulty_level')
                    ->label('Kesulitan')
                    ->options([
                        1 => 'Mudah',
                        2 => 'Sedang',
                        3 => 'Sulit',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDances::route('/'),
            'create' => Pages\CreateDance::route('/create'),
            'edit' => Pages\EditDance::route('/{record}/edit'),
        ];
    }
}
