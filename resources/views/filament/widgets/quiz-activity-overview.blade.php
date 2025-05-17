<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-500">Partisipasi Kuis</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalParticipation }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Skor Rata-rata</p>
                <p class="text-2xl font-bold text-gray-900">{{ $averageScore }}%</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Soal Paling Sering Salah</p>
                <p class="text-md font-medium text-gray-700">{{ $mostIncorrectQuestion }}</p>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
