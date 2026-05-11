{{-- Card Informasi --}}
<div class="grid grid-cols-1 gap-6 md:grid-cols-3 mb-8">
    <div
        class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm flex items-center space-x-4 border-l-4 border-l-pink-500 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-3 bg-pink-100 dark:brightness-75 rounded-full text-pink-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                </path>
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Kriteria Aktif</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $totalKriteria }} Kriteria</h3>
        </div>
    </div>

    <div
        class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm flex items-center space-x-4 border-l-4 border-l-pink-500 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-3 bg-pink-100 rounded-full dark:brightness-75 text-pink-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Status Konsistensi AHP</p>
            <h3 class="text-lg font-bold {{ $statusAhpColor }}">{{ $statusAhp }}</h3>
        </div>
    </div>

    <div
        class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm flex items-center space-x-4 border-l-4 border-l-pink-500 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-3 bg-pink-100 dark:brightness-75 rounded-full text-pink-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Siswa (Hasil Akhir)</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $totalSiswaDinilai }} Siswa</h3>
        </div>
    </div>
</div>