<div>
    <div class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        {{-- Loading Overlay --}}
        <div wire:loading wire:target="prosesPerankingan">

            <!-- Bungkus UI untuk memastikan posisi di tengah layar secara paksa -->
            <div
                class="fixed inset-0 top-0 left-0 z-[999999] flex items-center justify-center w-screen h-screen bg-black/60 backdrop-blur-sm">

                <!-- Card Loading Ukuran Sedang -->
                <div
                    class="flex flex-col items-center justify-center p-8 mx-4 bg-white border border-gray-200 shadow-2xl rounded-2xl dark:bg-gray-800 dark:border-gray-700 w-full max-w-sm">

                    <!-- Spinner Animation -->
                    <svg class="w-14 h-14 mb-5 text-blue-600 dark:text-blue-500 animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Menganalisis Data</h3>
                    <span class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 leading-relaxed">
                        Mesin Inferensi sedang menghitung<br>Z-Score dan Perankingan...
                    </span>
                </div>

            </div>
        </div>

        {{-- Main Title --}}
        <div>
            <h2 class="mb-2 text-2xl font-bold text-gray-800 dark:text-white/90">Hasil Perhitungan</h2>
            <p class="mb-6 text-gray-600 dark:text-gray-400">Setelah memasukkan excel, halaman ini digunakan untuk
                proses perhitungan akhir.</p>
        </div>

        {{-- Floating Alerts (Toasts) --}}
        <div class="fixed top-20 right-5 z-[999999] flex flex-col gap-3 pointer-events-none hidden-print">

            <!-- Alert Sukses (Pesan) -->
            @if (session()->has('pesan'))
            <!-- Tambahkan wire:key agar Alpine.js selalu di-reset oleh Livewire -->
            <div wire:key="alert-success-{{ time() }}" x-data="{ show: true }" x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center w-full max-w-sm p-4 bg-green-50 border border-green-200 shadow-xl pointer-events-auto rounded-xl dark:bg-green-900/40 dark:border-green-800/60">

                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-green-600 bg-green-200/50 rounded-lg dark:bg-green-800/50 dark:text-green-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                </div>
                <div class="ms-3 text-sm font-semibold text-green-800 dark:text-green-200">
                    {{ session('pesan') }}
                </div>
                <button @click="show = false" type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-green-600 hover:text-green-900 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200/50 inline-flex items-center justify-center h-8 w-8 dark:text-green-400 dark:hover:text-white dark:hover:bg-green-800/50 transition-colors">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            @endif

            <!-- Alert Error -->
            @if (session()->has('error'))
            <!-- Tambahkan wire:key agar Alpine.js selalu di-reset oleh Livewire -->
            <div wire:key="alert-error-{{ time() }}" x-data="{ show: true }" x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center w-full max-w-sm p-4 bg-red-50 border border-red-200 shadow-xl pointer-events-auto rounded-xl dark:bg-red-900/40 dark:border-red-800/60">

                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-red-600 bg-red-200/50 rounded-lg dark:bg-red-800/50 dark:text-red-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                </div>
                <div class="ms-3 text-sm font-semibold text-red-800 dark:text-red-200">
                    {{ session('error') }}
                </div>
                <button @click="show = false" type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-red-600 hover:text-red-900 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200/50 inline-flex items-center justify-center h-8 w-8 dark:text-red-400 dark:hover:text-white dark:hover:bg-red-800/50 transition-colors">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            @endif

        </div>

        {{-- Card Proses --}}
        <div
            class="p-6 mb-6 rounded-2xl border border-gray-200 bg-blue-50 pt-4 dark:border-gray-800 dark:bg-blue-950/50 hidden-print">
            <div class="flex items-end space-x-4">
                <div class="w-1/4">
                    <label for="filterKelas"
                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Pilih
                        Kelas</label>
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                        <select wire:model="filterKelas"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true">
                            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Kelas</option>
                            @foreach($listKelas as $lk) <option value="{{ $lk }}">{{ $lk }}</option> @endforeach
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

                </div>
                <div class="w-1/4">
                    <label for="filterTahunAjaran"
                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Pilih Tahun</label>
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                        <select wire:model="filterTahunAjaran"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true">
                            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Tahun Ajaran
                            </option>
                            @foreach($listTahun as $lt) <option value="{{ $lt }}">{{ $lt }}</option> @endforeach
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
                </div>
                <div class="w-1/2 flex space-x-2">
                    <button wire:click="prosesPerankingan" wire:loading.attr="disabled" wire:target="prosesPerankingan"
                        class="flex-1 flex items-center justify-center px-4 py-2 font-bold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition disabled:opacity-70 disabled:cursor-not-allowed">

                        <!-- Icon Spinner (Hanya tampil saat loading) -->
                        <svg wire:loading wire:target="prosesPerankingan" class="w-5 h-5 mr-2 text-white animate-spin"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <!-- Teks Dinamis -->
                        <span wire:loading.remove wire:target="prosesPerankingan">Mulai Hitung</span>
                        <span wire:loading wire:target="prosesPerankingan">Menghitung...</span>
                    </button>
                    <button onclick="window.print()"
                        class="px-4 py-2 font-bold text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 transition">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                            </svg>

                        </span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
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
                            <input type="text" wire:model.live.debounce.300ms="searchSiswa"
                                placeholder="Cari NIS / Nama..."
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
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
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
                                        <span
                                            class="text-sm font-semibold text-gray-800 dark:text-white/90 dark:text-gray-400">
                                            @if($hasil->peringkat == 1) 🥇
                                            @elseif($hasil->peringkat == 2) 🥈
                                            @elseif($hasil->peringkat == 3) 🥉
                                            @endif
                                            {{ $hasil->peringkat }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm font-semibold text-gray-800 dark:text-white/90 dark:text-gray-400">
                                            <span class="text-xs font-normal block text-gray-500 dark:text-white/90">{{
                                                $hasil->siswa->nis }}</span>
                                            {{ $hasil->siswa->nama_siswa }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm font-semibold text-gray-800 dark:text-white/90 dark:text-gray-400">
                                            {{ number_format($hasil->total_skor_z, 4) }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                        {{ $hasil->status == 'Sangat Terampil' ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500' : 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-orange-400' }}">
                                            {{ $hasil->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden-print">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            <button wire:key="btn-detail-{{ $hasil->siswa_id }}"
                                                wire:click="bukaDetail({{ $hasil->siswa_id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="bukaDetail({{ $hasil->siswa_id }})"
                                                class="inline-flex items-center justify-center min-w-[100px] px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200 dark:bg-indigo-500/20 dark:text-indigo-300 dark:hover:bg-indigo-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">

                                                <!-- Spinner Detail -->
                                                <svg wire:loading wire:target="bukaDetail({{ $hasil->siswa_id }})"
                                                    class="w-4 h-4 mr-1.5 animate-spin"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>

                                                <!-- Teks Normal -->
                                                <span wire:loading.remove
                                                    wire:target="bukaDetail({{ $hasil->siswa_id }})">
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
    </div>

    {{-- Modal Detail Z --}}
    @if ($isModalDetailOpen && $detailSiswa)

    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open"
                class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm hidden-print transition-all">

                <!-- Box Modal dengan styling mirip Main Design -->
                <div @click.outside="$wire.set('isModalDetailOpen', false)"
                    class="w-full max-w-4xl p-6 bg-white border border-gray-200 rounded-2xl shadow-theme-xl max-h-[90vh] overflow-y-auto dark:border-gray-800 dark:bg-gray-900">

                    <!-- Header Modal -->
                    <div
                        class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Transparansi Perhitungan
                            Algoritma</h3>
                        <button wire:click="$set('isModalDetailOpen', false)"
                            class="text-gray-400 transition-colors hover:text-red-500 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Info Siswa -->
                    <div
                        class="p-4 mb-5 border border-blue-100 rounded-xl bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800/30">
                        <p class="text-gray-700 dark:text-gray-300">
                            Siswa: <strong class="text-blue-700 dark:text-blue-400">{{ $detailSiswa->siswa->nama_siswa
                                }}</strong> |
                            Skor Akhir (Z): <strong class="text-gray-900 dark:text-white">{{
                                number_format($detailSiswa->total_skor_z, 4) }}</strong>
                        </p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Nilai Akhir didapat dari: Σ (Z Kriteria
                            × Bobot AHP)</p>
                    </div>

                    <!-- Grid Perhitungan -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($detailSiswa->rincian as $kriteria_id => $log)

                        @php
                        $dataPenilaian = $detailSiswa->siswa->penilaians->firstWhere('kriteria_id', $kriteria_id);
                        $namaKriteria = $dataPenilaian ? $dataPenilaian->kriteria->nama_kriteria : 'Kriteria ' .
                        $kriteria_id;
                        @endphp

                        <!-- Card Kriteria (Support Dark Mode) -->
                        <div
                            class="p-5 border border-gray-200 rounded-xl bg-gray-50 dark:bg-white/[0.02] dark:border-gray-800">
                            <h4
                                class="pb-2 mb-3 font-bold text-indigo-700 border-b border-indigo-100 dark:text-indigo-400 dark:border-indigo-500/20">
                                {{ $namaKriteria }}
                            </h4>
                            <ul class="mb-4 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                <li>Nilai Asli Siswa (x): <strong class="text-gray-800 dark:text-gray-200">{{
                                        $log['nilai_asli'] }}</strong></li>
                                <li>Bobot Prioritas (AHP): <strong class="text-gray-800 dark:text-gray-200">{{
                                        $log['bobot_ahp'] }}</strong></li>
                            </ul>

                            <div class="overflow-hidden border border-gray-200 rounded-lg dark:border-gray-700">
                                <table class="w-full text-xs text-left">
                                    <thead
                                        class="bg-indigo-50 dark:bg-indigo-900/20 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 font-medium">Rule</th>
                                            <th
                                                class="px-3 py-2 font-medium border-l border-gray-200 dark:border-gray-700">
                                                α (Predikat)</th>
                                            <th
                                                class="px-3 py-2 font-medium border-l border-gray-200 dark:border-gray-700">
                                                Z Rule</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($log['rules'] as $rule)
                                        <tr class="text-gray-600 dark:text-gray-400 bg-white dark:bg-transparent">
                                            <td class="px-3 py-2">IF {{ $rule['himpunan'] }} THEN {{ $rule['kesimpulan']
                                                }}</td>
                                            <td
                                                class="px-3 py-2 font-mono border-l border-gray-200 dark:border-gray-700">
                                                {{ $rule['alpha'] }}</td>
                                            <td
                                                class="px-3 py-2 font-mono border-l border-gray-200 dark:border-gray-700">
                                                {{ $rule['z_rule'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 text-sm font-bold text-right text-gray-800 dark:text-white/90">
                                Z Kriteria Defuzzifikasi = <span class="text-indigo-600 dark:text-indigo-400">{{
                                    $log['z_kriteria'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </template>
    </div>
    @endif


    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }

            body {
                background-color: white !important;
            }

            .shadow-md {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>

</div>