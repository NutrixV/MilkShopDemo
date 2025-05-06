<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\CategoryRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\FileUpload::make('image_path')
                    ->image(),
                Forms\Components\Toggle::make('in_stock')
                    ->required(),
                Forms\Components\TextInput::make('fat_content')
                    ->maxLength(255),
                Forms\Components\TextInput::make('volume')
                    ->numeric(),
                Forms\Components\TextInput::make('unit')
                    ->required()
                    ->maxLength(10)
                    ->default('ml'),
                Forms\Components\DatePicker::make('expiration_date'),
                Forms\Components\TextInput::make('manufacturer')
                    ->maxLength(255),
                Forms\Components\TextInput::make('storage_temp')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_organic')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_path'),
                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean(),
                Tables\Columns\TextColumn::make('fat_content')
                    ->searchable(),
                Tables\Columns\TextColumn::make('volume')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expiration_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manufacturer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('storage_temp')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_organic')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            CategoryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
