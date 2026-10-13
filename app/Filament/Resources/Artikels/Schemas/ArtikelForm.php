<?php

namespace App\Filament\Resources\Artikels\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ArtikelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Hidden::make('id_user')
                ->default(fn () => Auth::id()),

            TextInput::make('judul')
                ->label('Judul')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Select::make('id_kategori')
                ->label('Kategori')
                ->relationship('kategori', 'nama_kategori')
                ->searchable()
                ->preload()
                ->required()
                ->createOptionForm([
                    TextInput::make('nama_kategori')
                        ->label('Nama Kategori')
                        ->required()
                        ->maxLength(255),
                ]),

            DatePicker::make('tanggal_publikasi')
                ->label('Tanggal Publikasi')
                ->default(now())
                ->required(),

            FileUpload::make('thumbnail')
                ->label('Thumbnail')
                ->image()
                ->disk('public')
                ->directory('artikel')
                ->visibility('public')
                ->imageEditor()
                ->columnSpanFull(),

            RichEditor::make('isi')
                ->label('Isi Artikel')
                ->required()
                ->columnSpanFull(),
        ])->columns(2);
    }
}