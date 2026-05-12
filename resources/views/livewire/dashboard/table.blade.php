{{-- Card Top 5 Siswa --}}
<div class="bg-white border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] rounded-lg shadow-sm">
    <div
        class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] rounded-t-lg">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white/90">Top 5 Siswa Paling Terampil</h3>

        <div class="flex items-center gap-2">
            <div x-data="{ openFilter: false }" class="relative">

                <button @click="openFilter = !openFilter" type="button"
                    class="inline-flex items-center gap-2 h-[42px] px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-theme-xs hover:bg-gray-50 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:bg-gray-900 dark:text-white/90 dark:border-gray-700 dark:hover:bg-gray-800 dark:focus:border-blue-800 transition-colors w-full sm:w-auto justify-center">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75">
                        </path>
                    </svg>
                    Filter
                    <svg class="w-4 h-4 ml-1 transition-transform" :class="openFilter ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="openFilter" @click.outside="openFilter = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2" style="display: none;"
                    class="absolute left-0 sm:right-auto z-[99] w-[280px] p-4 mt-2 bg-white border border-gray-200 rounded-2xl shadow-xl dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-4">

                    <div class="pb-2 border-b border-gray-100 dark:border-gray-700">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">Filter Siswa</h4>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-gray-500 dark:text-gray-400">Pilih
                            Kelas</label>
                        <div x-data="{ isOptionSelected: false }" class="relative bg-transparent">
                            <select wire:model.live="filterKelas"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                @change="isOptionSelected = true">
                                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua Kelas
                                </option>
                                @foreach($listKelas as $lk) <option value="{{ $lk }}">{{ $lk }}</option> @endforeach
                            </select>
                            <span
                                class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-gray-500 dark:text-gray-400">Pilih Tahun
                            Ajaran</label>
                        <div class="relative bg-transparent" x-data="{ isOptionSelected: false }">
                            <select wire:model.live="filterTahunAjaran"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                @change="isOptionSelected = true">
                                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua Tahun
                                </option>
                                @foreach($listTahun as $lt) <option value="{{ $lt }}">{{ $lt }}</option> @endforeach
                            </select>
                            <span
                                class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-gray-500 dark:text-gray-400">Pilih
                            Semester</label>
                        <div class="relative bg-transparent" x-data="{ isOptionSelected: false }">
                            <select wire:model.live="filterSemester"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                @change="isOptionSelected = true">
                                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua
                                    Semester</option>
                                @foreach($listSemester as $ls) <option value="{{ $ls }}">{{ $ls }}</option> @endforeach
                            </select>
                            <span
                                class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <button type="button"
                        @click="$wire.set('filterKelas', ''); $wire.set('filterTahunAjaran', ''); $wire.set('filterSemester', ''); openFilter = false"
                        class="mt-2 w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20 transition-colors">
                        Reset Filter
                    </button>

                </div>
            </div>
            <a href="{{ route('hasil.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Lihat Semua
            </a>
        </div>
    </div>

    <div class="relative">
        <!--- Loading -->
        <div wire:loading wire:target="search, filterKelas, filterTahunAjaran, filterSemester, gotoPage, previousPage, nextPage">
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
                            @if($hasil->peringkat == 1) <span class="text-yellow-500">1</span>
                            @elseif($hasil->peringkat == 2) <span class="text-gray-400">2</span>
                            @elseif($hasil->peringkat == 3) <span class="text-orange-500">3</span>
                            @else <span class="ml-2">{{ $hasil->peringkat }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-base font-semibold text-gray-800 dark:text-white/90">{{
                            $hasil->siswa->nama_siswa }}</td>
                        <td class="px-6 py-3">
                            <span class="block text-sm font-medium text-blue-600 dark:text-blue-400">{{
                                $hasil->siswa->kelas }} / {{ $hasil->siswa->semester }}</span>
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