<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupData extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static string $view = 'filament.admin.pages.backup-data';
    protected static ?string $navigationLabel = 'Backup & Export';
    protected static ?string $navigationGroup = 'Settings';

    public function downloadBackup()
    {
        $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/' . $filename);

        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        $command = "mysqldump -u $dbUser -p$dbPass $dbName > $path";
        $result = null;
        system($command, $result);

        if ($result === 0) {
            return response()->download($path)->deleteFileAfterSend();
        } else {
            Notification::make()
                ->title('Backup gagal')
                ->danger()
                ->send();
        }
    }

    public function importBackup(array $data)
    {
        $file = $data['file'];

        $path = $file->storeAs('backups', $file->getClientOriginalName());

        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $fullPath = storage_path('app/' . $path);

        $command = "mysql -u $dbUser -p$dbPass $dbName < $fullPath";
        $result = null;
        system($command, $result);

        if ($result === 0) {
            Notification::make()
                ->title('Import berhasil')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Import gagal')
                ->danger()
                ->send();
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('file')
                    ->label('File SQL untuk import')
                    ->disk('local')
                    ->directory('backups')
                    ->acceptedFileTypes(['.sql'])
                    ->required(),
            ])
            ->statePath('data');
    }

    public $data = [];
}
