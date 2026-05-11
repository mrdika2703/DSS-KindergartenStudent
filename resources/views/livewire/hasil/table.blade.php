<div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">



    <!-- Header -->
    <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Daft Siswa</h3>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center hidden-print">
            <form>
                <div class="relative">
                    <button type="button" class="absolute -translate-y-1/2 left-4 top-1/2">
                        <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                fill="" />
                        </svg>
                    </button>
                    <input type="text" wire:model.live.debounce.300ms="searchSiswa" placeholder="Cari NIS / Nama..."
                        class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[300px]" />
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->

    <div class="relative">


        <!-- Efek Loading -->
        <div wire:loading wire:target="searchSiswa, gotoPage, previousPage, nextPage">
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

        <div class="overflow-hidden">
            <div class="max-w-full px-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-200 border-y dark:border-gray-700">
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-center text-theme-sm dark:text-gray-400">
                                Peringkat</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Nama Lengkap</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Skor Z</th>
                            <th scope="col"
                                class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                Keterangan</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400 hidden-print">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($hasilAkhir as $hasil)
                        <tr>
                            <td class="py-4 text-center">
                                <span class="text-sm font-semibold text-gray-800 dark:text-white/90 dark:text-gray-400">
                                    @if($hasil->peringkat == 1) 🥇
                                    @elseif($hasil->peringkat == 2) 🥈
                                    @elseif($hasil->peringkat == 3) 🥉
                                    @endif
                                    {{ $hasil->peringkat }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-800 dark:text-white/90 dark:text-gray-400">
                                    <span class="text-xs font-normal block text-gray-500 dark:text-white/90">{{
                                        $hasil->siswa->nis }}</span>
                                    {{ $hasil->siswa->nama_siswa }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-800 dark:text-white/90 dark:text-gray-400">
                                    {{ number_format($hasil->total_skor_z, 4) }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                        {{ $hasil->status == 'Sangat Terampil' ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500' : ($hasil->status == 'Terampil' ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500' : 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-orange-400') }}">
                                    {{ $hasil->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap hidden-print">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    <button wire:key="btn-detail-{{ $hasil->siswa_id }}"
                                        wire:click="bukaDetail({{ $hasil->siswa_id }})" wire:loading.attr="disabled"
                                        wire:target="bukaDetail({{ $hasil->siswa_id }})"
                                        class="inline-flex items-center justify-center min-w-[100px] px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200 dark:bg-indigo-500/20 dark:text-indigo-300 dark:hover:bg-indigo-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">

                                        <!-- Spinner Detail -->
                                        <svg wire:loading wire:target="bukaDetail({{ $hasil->siswa_id }})"
                                            class="w-4 h-4 mr-1.5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>

                                        <!-- Teks Normal -->
                                        <span wire:loading.remove wire:target="bukaDetail({{ $hasil->siswa_id }})">
                                            Detail Z
                                        </span>
                                    </button>
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-gray-800 dark:text-white/90 text-center">
                                Belum ada data perankingan untuk kelas dan tahun ajaran ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="px-6 py-4 border-t border-gray-200 dark:border-white/[0.05] hidden-print">
        {{ $hasilAkhir->links() }}
    </div>

</div>