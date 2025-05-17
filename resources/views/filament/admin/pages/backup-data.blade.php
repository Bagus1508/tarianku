<x-filament-panels::page>
    <div class="space-y-4">
        <x-filament::button wire:click="downloadBackup">
            Backup dan Download Data (.sql)
        </x-filament::button>

        <form wire:submit.prevent="importBackup" class="space-y-4" enctype="multipart/form-data">
            {{ $this->form }}

            <x-filament::button type="submit" color="primary">
                Import SQL File
            </x-filament::button>
        </form>
    </div>
</x-filament-panels::page>