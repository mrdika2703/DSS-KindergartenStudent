{{-- Section 2: Table Card --}}
<div x-data="{ showConfirmNilaiModal: false, showConfirmSiswaModal: false, deleteId: null }"
    class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

    <!-- Modal Konfirmasi Nilai -->
    <template x-teleport="body">
        <div x-show="showConfirmNilaiModal" style="display: none;"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-opacity"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click.outside="showConfirmNilaiModal = false"
                class="w-full max-w-sm p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900 transform transition-all"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div
                    class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full dark:bg-red-900/30">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>

                <h3 class="mb-2 text-lg font-bold text-center text-gray-800 dark:text-white/90">Hapus Data
                    Penilaian?</h3>
                <p class="mb-6 text-sm text-center text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat
                    dibatalkan. Semua nilai terkait siswa ini akan dihapus permanen.</p>

                <div class="flex justify-center space-x-3">
                    <button @click="showConfirmNilaiModal = false" type="button"
                        class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors w-1/2">
                        Batal
                    </button>
                    <button @click="$wire.hapusPenilaian(deleteId); showConfirmNilaiModal = false" type="button"
                        class="px-4 py-2.5 text-sm font-bold text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition-colors w-1/2">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </template>

    <!-- Modal Konfirmasi Siswa -->
    <template x-teleport="body">
        <div x-show="showConfirmSiswaModal" style="display: none;"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-opacity"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click.outside="showConfirmSiswaModal = false"
                class="w-full max-w-sm p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900 transform transition-all"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div
                    class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full dark:bg-red-900/30">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>

                <h3 class="mb-2 text-lg font-bold text-center text-gray-800 dark:text-white/90">Hapus Data Siswa?</h3>
                <p class="mb-6 text-sm text-center text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat
                    dibatalkan. Semua nilai terkait siswa ini akan dihapus permanen.</p>

                <div class="flex justify-center space-x-3">
                    <button @click="showConfirmSiswaModal = false" type="button"
                        class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors w-1/2">
                        Batal
                    </button>
                    <button @click="$wire.hapusSiswa(deleteId); showConfirmSiswaModal = false" type="button"
                        class="px-4 py-2.5 text-sm font-bold text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition-colors w-1/2">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </template>

    <!-- Table Header (Filters) -->
    <div class="flex flex-col gap-4 px-5 mb-4 lg:flex-row lg:items-center lg:justify-between sm:px-6 hidden-print">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">2. Hasil Preprocessing</h3>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

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

            <div class="relative w-full sm:w-auto">
                <button type="button" class="absolute -translate-y-1/2 left-4 top-1/2">
                    <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                            fill="" />
                    </svg>
                </button>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Siswa..."
                    class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[250px]" />
            </div>

        </div>
    </div>

    <div class="relative">
        <!-- Table Loading Blur (Tbody Only) -->
        <div wire:loading
            wire:target="search, filterKelas, filterTahunAjaran, filterSemester, gotoPage, previousPage, nextPage">
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

        <!-- Data Table -->
        <div class="overflow-hidden">
            <div class="max-w-full px-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-200 border-y dark:border-gray-700">
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Profil Siswa</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Akademik</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Absensi</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Capaian</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Ekstrakurikuler</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-center text-theme-sm dark:text-gray-400 hidden-print">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($siswas as $siswa)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                    <span class="text-xs font-normal block text-gray-500 dark:text-gray-400">{{
                                        $siswa->nis }}</span>
                                    {{ $siswa->nama_siswa }}
                                </div>
                                <div class="mt-1 flex gap-2">
                                    <span
                                        class="px-2 py-0.5 inline-flex text-[10px] leading-5 font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">{{
                                        $siswa->kelas }}/{{ $siswa->semester }}</span>
                                    <span
                                        class="px-2 py-0.5 inline-flex text-[10px] leading-5 font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400">TA:
                                        {{ $siswa->tahun_ajaran }}</span>
                                </div>
                            </td>

                            @foreach ($kriterias as $k)
                            @php $nilai = $siswa->penilaians->firstWhere('kriteria_id', $k->id); @endphp
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                <div class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $nilai ?
                                    number_format($nilai->nilai, 2) : '-' }}</div>
                            </td>
                            @endforeach

                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Tombol Rapor -->
                                    <button wire:key="btn-rapor-{{ $siswa->id }}"
                                        wire:click="lihatDetailMentah({{ $siswa->id }})" wire:loading.attr="disabled"
                                        wire:target="lihatDetailMentah({{ $siswa->id }})"
                                        class="inline-flex items-center justify-center w-8 h-8 text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 dark:bg-blue-500/20 dark:text-blue-300 dark:hover:bg-blue-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                        <svg wire:loading wire:target="lihatDetailMentah({{ $siswa->id }})"
                                            class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <svg wire:loading.remove wire:target="lihatDetailMentah({{ $siswa->id }})"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown -->
                                    <div x-data="{ 
                                                dropdownOpen: false,
                                                posTop: 0,
                                                posLeft: 0,
                                                setPos() {
                                                    // Ambil posisi tombol saat ini di layar
                                                    const rect = this.$refs.dropdownBtn.getBoundingClientRect();
                                                    // Kalkulasi posisi X dan Y dropdown (160px adalah ukuran lebar class w-40)
                                                    this.posTop = rect.bottom + window.scrollY + 4; 
                                                    this.posLeft = rect.right + window.scrollX - 160; 
                                                }
                                                }" @resize.window="dropdownOpen = false"
                                        class="relative inline-block text-left">

                                        <button x-ref="dropdownBtn" wire:key="btn-rapor-{{ $siswa->id }}"
                                            @click="dropdownOpen = !dropdownOpen; if(dropdownOpen) $nextTick(() => setPos());"
                                            type="button"
                                            class="inline-flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-50 border border-gray-200 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/50 disabled:opacity-70 disabled:cursor-wait">

                                            <svg wire:loading
                                                wire:target="bukaModalManual({{ $siswa->id }}), editSiswa({{ $siswa->id }})"
                                                class="w-4 h-4 animate-spin text-blue-600 dark:text-blue-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>

                                            <svg wire:loading.remove
                                                wire:target="bukaModalManual({{ $siswa->id }}), editSiswa({{ $siswa->id }})"
                                                class="w-5 h-5 fill-current" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z" />
                                            </svg>
                                        </button>

                                        <template x-teleport="body">
                                            <div x-show="dropdownOpen" @click.outside="dropdownOpen = false"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                :style="`top: ${posTop}px; left: ${posLeft}px;`" style="display: none;"
                                                class="absolute z-[999999] w-40 origin-top-right bg-white border border-gray-200 rounded-lg shadow-xl dark:bg-gray-800 dark:border-gray-700 overflow-hidden">

                                                <div class="py-1">
                                                    <!-- Edit Rapor -->
                                                    <button wire:key="btn-edit-{{ $siswa->id }}"
                                                        wire:click="bukaModalManual({{ $siswa->id }})"
                                                        @click="dropdownOpen = false"
                                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors">
                                                        Edit Data Rapot
                                                    </button>

                                                    <!-- Hapus Rapor -->
                                                    <button wire:key="btn-hapus-{{ $siswa->id }}"
                                                        @click="deleteId = {{ $siswa->id }}; showConfirmNilaiModal = true; dropdownOpen = false"
                                                        class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300 transition-colors">
                                                        Hapus Rapot
                                                    </button>

                                                    <div class="border-t border-gray-100 dark:border-gray-700 my-1">
                                                    </div>

                                                    <!-- Edit  Siswa -->
                                                    <button wire:key="btn-edit-siswa-{{ $siswa->id }}"
                                                        wire:click="editSiswa({{ $siswa->id }})"
                                                        @click="dropdownOpen = false"
                                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors">
                                                        Edit Profil Siswa
                                                    </button>

                                                    <!-- Hapus  Siswa -->
                                                    <button wire:key="btn-hapus-siswa-{{ $siswa->id }}"
                                                        @click="deleteId = {{ $siswa->id }}; showConfirmSiswaModal = true; dropdownOpen = false"
                                                        class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300 transition-colors">
                                                        Hapus Data Siswa
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ 2 + count($kriterias) }}"
                                class="px-4 py-8 text-sm text-center text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
                                Data penilaian tidak ditemukan. Silakan lakukan import data Excel di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="px-6 py-4 border-t border-gray-200 dark:border-white/[0.05] hidden-print">
        {{ $siswas->links() }}
    </div>
</div>