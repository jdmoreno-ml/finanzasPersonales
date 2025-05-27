<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Movement;
use App\Models\User;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
// use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\TextInput\Maskable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make('Movement Details')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->required()
                            ->relationship('user', 'name')
                            ->label('Users')
                            ->options(User::all()->pluck('name', 'id')),
                        Forms\Components\Select::make('category_id')
                            ->required()
                            ->relationship('category', 'name')
                            ->label('Categories')
                            ->options(Category::all()->pluck('name', 'id')),
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options([
                                'ingreso' => 'Income',
                                'gasto' => 'Spent',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount (COP)')
                            ->required()
                            ->numeric(),
                        Forms\Components\RichEditor::make('description')
                            // ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('photo')
                            ->label('Photo')
                            ->disk('public')
                            ->directory('movements')
                            ->image(),
                        Forms\Components\DatePicker::make('date')
                            ->required(),
                    ])
                    ->columns(2),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('#')
                    ->rowIndex()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->width(50)
                    ->height(50)
                    // ->circular(10)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'ingreso' => 'Ingreso',
                        'gasto' => 'Gasto',
                    ])
                    ->label('Category Type'),
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-o-pencil')
                    ->successNotification(
                        Notification::make()
                            ->title('Movement updated successfully')
                            ->warning()
                            ->body('The Movement has been updated successfully.')
                    ),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->button()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->successNotification(
                        Notification::make()
                            ->title('Movement deleted successfully')
                            ->success()
                            ->body('The Movement has been deleted successfully.')
                    ),
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
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/create'),
            'edit' => Pages\EditMovement::route('/{record}/edit'),
        ];
    }
}
