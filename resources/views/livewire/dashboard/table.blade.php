{{-- Card Top 5 Siswa --}}
<div class="bg-white border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] rounded-lg shadow-sm">
    <div
        class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] rounded-t-lg">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white/90">Top 5 Siswa Paling Terampil</h3>

        <div class="flex items-center gap-2">
            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                <select wire:model.live="filterKelas"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'" @change="isOptionSelected = true">
                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                        Semua Kelas
                    </option>
                    @foreach($listKelas as $lk)
                    <option value="{{ $lk }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ $lk }}
                    </option>
                    @endforeach

                </select>
                <span
                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                <select wire:model.live="filterTahunAjaran"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'" @change="isOptionSelected = true">
                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                        Semua Tahun Ajaran
                    </option>
                    @foreach($listTahun as $lt)
                    <option value="{{ $lt }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ $lt }}
                    </option>
                    @endforeach
                </select>
                <span
                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
            <a href="{{ route('hasil.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Lihat Semua
            </a>
        </div>
        {{-- <a href="{{ route('hasil.index') }}"
            class="text-sm text-blue-600 dark:text-blue-400 hover:brightness-120">Lihat Seluruh Peringkat &rarr;</a>
        --}}
    </div>

    <div class="relative">
        <!--- Loading -->
        <div wire:loading wire:target="search, filterKelas, filterTahunAjaran, gotoPage, previousPage, nextPage">
            <div
                class="absolute inset-0 z-50 flex justify-center items-start pt-24 bg-white/30 dark:bg-gray-900/30 backdrop-blur-sm transition-all duration-300">
                <div
                    class="p-3 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                    <svg class="w-10 h-10 text-blue-600 dark:text-blue-500 animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="max-w-full px-5 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-gray-200 border-y dark:border-gray-700">
                        <th class="p-3 text-center">
                            <p class="font-medium text-gray-500 text-theme-sm dark:text-gray-400">Rank</p>
                        </th>
                        <th class="p-3 text-center">
                            <p class="font-medium text-gray-500 text-theme-sm dark:text-gray-400">Nama Siswa</p>
                        </th>
                        <th class="p-3 text-center">
                            <p class="font-medium text-gray-500 text-theme-sm dark:text-gray-400">Kelas</p>
                        </th>
                        <th class="p-3 text-center">
                            <p class="font-medium text-gray-500 text-theme-sm dark:text-gray-400">Skor Z</p>
                        </th>
                        <th class="p-3 text-center">
                            <p class="font-medium text-gray-500 text-theme-sm dark:text-gray-400">Status</p>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($topSiswa as $hasil)
                    <tr>
                        <td class="px-6 py-3 text-base font-medium text-gray-700">
                            @if($hasil->peringkat == 1) <span class="text-yellow-500">🥇 1</span>
                            @elseif($hasil->peringkat == 2) <span class="text-gray-400">🥈 2</span>
                            @elseif($hasil->peringkat == 3) <span class="text-orange-500">🥉 3</span>
                            @else <span class="ml-2">{{ $hasil->peringkat }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-base font-semibold text-gray-800 dark:text-white/90">{{
                            $hasil->siswa->nama_siswa }}</td>
                        <td class="px-6 py-3">
                            <span class="block text-sm font-medium text-blue-600 dark:text-blue-400">{{
                                $hasil->siswa->kelas }}</span>
                            <span class="text-xs text-gray-500 text-theme-sm dark:text-gray-400">{{
                                $hasil->siswa->tahun_ajaran }}</span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-500">
                                {{ number_format($hasil->total_skor_z, 4) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $hasil->status == 'Sangat Terampil' ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500' : ($hasil->status == 'Terampil' ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500' : 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-orange-400') }}">
                                {{ strtoupper($hasil->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-600 dark:text-gray-400">
                            <p class="mb-2">Belum ada data pemeringkatan untuk filter yang dipilih.</p>
                            <a href="{{ route('hasil.index') }}"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:brightness-120">Silakan
                                eksekusi algoritma di Halaman Hasil Akhir.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>