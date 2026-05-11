<div>
    <div
        class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] relative">

        {{-- Loading Overlay Full Screen (Proses Berat) --}}
        <div wire:loading class="hidden-print"
            wire:target="switchTab, importExcel, bukaModal, unduhTemplate, resetDataSiswa, hapusPenilaian, simpanManual">
            <div
                class="fixed inset-0 top-0 left-0 z-[999999] flex items-center justify-center w-screen h-screen bg-black/60 backdrop-blur-sm">
                <div
                    class="flex flex-col items-center justify-center p-8 mx-4 bg-white border border-gray-200 shadow-2xl rounded-2xl dark:bg-gray-800 dark:border-gray-700 w-full max-w-sm">
                    <svg class="w-14 h-14 mb-5 text-blue-600 dark:text-blue-500 animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Sistem Memproses</h3>
                    <span class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 leading-relaxed">
                        Harap tunggu sebentar, data sedang diproses...
                    </span>
                </div>
            </div>
        </div>

        {{-- Main Title --}}
        <div>
            <h2 class="mb-2 text-2xl font-bold text-gray-800 dark:text-white/90">Manajemen Penilaian Siswa</h2>
            <p class="mb-6 text-gray-600 dark:text-gray-400">Upload excel penilaian dengan template yang disediakan lalu
                sistem akan masuk ke perhitungan praproses.</p>
        </div>

        {{-- Floating Alerts (Toasts) --}}
        <div class="fixed top-20 right-5 z-[999999] flex flex-col gap-3 pointer-events-none hidden-print">
            <!-- Alert Sukses -->
            @if (session()->has('pesan'))
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
                <div class="ms-3 text-sm font-semibold text-green-800 dark:text-green-200">{{ session('pesan') }}</div>
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
                <div class="ms-3 text-sm font-semibold text-red-800 dark:text-red-200">{{ session('error') }}</div>
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

        {{-- Tabs Menu --}}
        <div class="flex mb-6 border-b border-gray-200 dark:border-gray-700 hidden-print">
            <button wire:click="switchTab('import')"
                class="px-5 py-3 font-semibold text-sm transition-colors duration-200 {{ $tabAktif == 'import' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Import & Proses
            </button>
            <button wire:click="switchTab('other')"
                class="px-5 py-3 font-semibold text-sm transition-colors duration-200 {{ $tabAktif == 'other' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Other
            </button>
        </div>

        {{-- Section 1: Import Data Card --}}
        @if ($tabAktif == 'import')
        <div
            class="p-6 mb-6 rounded-2xl border border-gray-200 bg-blue-50 pt-4 dark:border-gray-800 dark:bg-blue-950/5 hidden-print">
            <h3 class="mb-4 text-lg font-bold text-blue-800 dark:text-blue-400">1. Import Data dari Rapor (Excel)</h3>
            <form wire:submit.prevent="importExcel">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Kelas <span
                                class="text-red-500">*</span></label>
                        <div class="relative z-20 bg-transparent">
                            <select wire:model="inputKelas"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                @change="isOptionSelected = true">
                                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Pilih Kelas
                                </option>
                                <option value="Kelas A">Kelas A</option>
                                <option value="Kelas B">Kelas B</option>
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

                        @error('inputKelas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>

                        <div x-data="{
                                showPicker: false,
                                currentDecadeStart: Math.floor(new Date().getFullYear() / 10) * 10,
                                selectedYear: null,
                                displayValue: '',

                                // Generate 12 grid tahun untuk ditampilkan
                                get years() {
                                    let y = [];
                                    for (let i = 0; i < 12; i++) {
                                        y.push(this.currentDecadeStart + i - 1);
                                    }
                                    return y;
                                },

                                init() {
                                    // Ambil data dari Livewire jika dalam mode Edit
                                    let current = $wire.inputTahunAjaran;
                                    if (current && current.includes('/')) {
                                        this.displayValue = current;
                                        this.selectedYear = parseInt(current.split('/')[0]);
                                        this.currentDecadeStart = Math.floor(this.selectedYear / 10) * 10;
                                    }
                                },

                                selectYear(year) {
                                    this.selectedYear = year;
                                    // Otomatis bikin format 2024/2025
                                    this.displayValue = year + '/' + (year + 1);
                                    // Lempar ke Livewire
                                    $wire.set('inputTahunAjaran', this.displayValue);
                                    this.showPicker = false;
                                },

                                prevDecade() {
                                    this.currentDecadeStart -= 10;
                                },

                                nextDecade() {
                                    this.currentDecadeStart += 10;
                                }
                            }" class="relative w-full" @click.outside="showPicker = false">

                            <div class="relative custom-datepicker" @click="showPicker = !showPicker">
                                <input type="text" readonly x-model="displayValue" placeholder="Pilih Tahun Ajaran"
                                    class="h-11 w-full rounded-lg border appearance-none px-4 py-2.5 pl-10 text-sm shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 bg-transparent text-gray-800 border-gray-300 focus:border-blue-300 focus:ring-blue-500/20 dark:border-gray-700 dark:focus:border-blue-800 cursor-pointer" />
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500 dark:text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </span>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>

                            <div x-show="showPicker" x-transition style="display: none;"
                                class="absolute left-0 z-[99] w-64 p-4 mt-2 bg-white border border-gray-200 rounded-2xl shadow-xl top-full dark:bg-gray-800 dark:border-gray-700">

                                <div class="flex items-center justify-between mb-4">
                                    <button type="button" @click.stop="prevDecade"
                                        class="p-1.5 text-gray-600 rounded-full hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <span class="text-sm font-bold text-gray-800 dark:text-white"
                                        x-text="currentDecadeStart + ' - ' + (currentDecadeStart + 9)"></span>
                                    <button type="button" @click.stop="nextDecade"
                                        class="p-1.5 text-gray-600 rounded-full hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <template x-for="year in years" :key="year">
                                        <button type="button" @click="selectYear(year)"
                                            :class="{'bg-blue-600 text-white shadow-md font-bold': selectedYear === year, 'bg-gray-50 text-gray-700 hover:bg-blue-50 dark:bg-gray-900/50 dark:text-gray-300 dark:hover:bg-gray-700': selectedYear !== year}"
                                            class="py-2.5 text-sm transition-colors rounded-lg font-medium">
                                            <span x-text="year"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        @error('inputTahunAjaran') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">File Rapor Excel
                            <span class="text-red-500">*</span></label>
                        <input type="file" wire:model="fileExcel" accept=".xlsx, .xls, .csv"
                            placeholder="Klik untuk memilih file"
                            class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400" />
                        @error('fileExcel') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-2">
                    <button type="submit" wire:loading.attr="disabled" wire:target="fileExcel, importExcel"
                        class="flex items-center justify-center px-6 py-2.5 font-bold text-white bg-green-600 rounded-lg shadow hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 transition disabled:opacity-70 disabled:cursor-wait">
                        <svg wire:loading wire:target="fileExcel, importExcel"
                            class="w-5 h-5 mr-2 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove wire:target="fileExcel, importExcel">Upload & Proses Penilaian</span>
                        <span wire:loading wire:target="fileExcel, importExcel">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- Section 1: Other --}}
        @if ($tabAktif == 'other')
        <div x-data="{ showResetModal: false }"
            class="p-6 mb-6 rounded-2xl border border-gray-200 bg-blue-50 pt-4 dark:border-gray-800 dark:bg-blue-950/50 hidden-print">
            <h3 class="mb-4 text-lg font-bold text-blue-800 dark:text-blue-400">Tambah manual dan unduh template excel
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <button wire:click="bukaModal"
                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition whitespace-nowrap">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Tambah Siswa
                </button>

                <button wire:click="unduhTemplate"
                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-amber-600 rounded-lg shadow hover:bg-amber-700 dark:bg-amber-500 dark:hover:bg-amber-600 transition whitespace-nowrap">

                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                    </path>
                    </svg>
                    Unduh Template
                </button>

                <!-- Menggunakan wire:confirm untuk UX konfirmasi yang lebih baik di Livewire -->
                <button @click="showResetModal = true"
                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg shadow hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition whitespace-nowrap">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Reset Data
                </button>

                <template x-teleport="body">
                    <div x-show="showResetModal" style="display: none;"
                        class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-opacity"
                        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                        <div @click.outside="showResetModal = false"
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

                            <h3 class="mb-2 text-lg font-bold text-center text-gray-800 dark:text-white/90">
                                Reset Semua Data?
                            </h3>
                            <p class="mb-6 text-sm text-center text-gray-500 dark:text-gray-400">
                                Peringatan Keras! Tindakan ini tidak dapat dibatalkan. Semua data siswa, nilai rapor,
                                dan hasil perhitungan akan dihapus permanen.
                            </p>

                            <div class="flex justify-center space-x-3">
                                <button @click="showResetModal = false" type="button"
                                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors w-1/2">
                                    Batal
                                </button>
                                <button @click="$wire.resetDataSiswa(); showResetModal = false" type="button"
                                    class="px-4 py-2.5 text-sm font-bold text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition-colors w-1/2 flex items-center justify-center">
                                    <span wire:loading.remove wire:target="resetDataSiswa">Ya, Reset</span>
                                    <span wire:loading wire:target="resetDataSiswa">Proses...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        @endif

        {{-- Section 2: Table Card --}}
        <div x-data="{ showConfirmModal: false, deleteId: null }"
            class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

            <!-- Modal Konfirmasi -->
            <template x-teleport="body">
                <div x-show="showConfirmModal" style="display: none;"
                    class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-opacity"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                    <div @click.outside="showConfirmModal = false"
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
                            <button @click="showConfirmModal = false" type="button"
                                class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors w-1/2">
                                Batal
                            </button>
                            <button @click="$wire.hapusPenilaian(deleteId); showConfirmModal = false" type="button"
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
                    <!-- Filter Kelas -->
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                        <select wire:model.live="filterKelas"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true">
                            <option value="" value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua
                                Kelas</option>
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

                    <!-- Filter Tahun -->
                    <div class="relative z-20 bg-transparent" x-data="{ isOptionSelected: false }">
                        <select wire:model.live="filterTahunAjaran"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true">
                            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua Tahun
                            </option>
                            @foreach($listTahun as $lt)
                            <option value="{{ $lt }}">{{ $lt }}</option>
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
                    <!-- Pencarian -->
                    <div class="relative">
                        <button type="button" class="absolute -translate-y-1/2 left-4 top-1/2">
                            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
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
                    wire:target="search, filterKelas, filterTahunAjaran, gotoPage, previousPage, nextPage">
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
                                                $siswa->kelas }}</span>
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
                                                wire:click="lihatDetailMentah({{ $siswa->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="lihatDetailMentah({{ $siswa->id }})"
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 dark:bg-blue-500/20 dark:text-blue-300 dark:hover:bg-blue-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                                <svg wire:loading wire:target="lihatDetailMentah({{ $siswa->id }})"
                                                    class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                <svg wire:loading.remove
                                                    wire:target="lihatDetailMentah({{ $siswa->id }})"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
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
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
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
                                                        :style="`top: ${posTop}px; left: ${posLeft}px;`"
                                                        style="display: none;"
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
                                                                @click="deleteId = {{ $siswa->id }}; showConfirmModal = true; dropdownOpen = false"
                                                                class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300 transition-colors">
                                                                Hapus Rapot
                                                            </button>

                                                            <div
                                                                class="border-t border-gray-100 dark:border-gray-700 my-1">
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
                                                                @click="deleteId = {{ $siswa->id }}; showConfirmModal = true; dropdownOpen = false"
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
    </div>

    {{-- Modal 1: Detail Arsip Rapor (Mentah) --}}
    @if ($isModalDetailOpen)
    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open"
                class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all">
                <div @click.outside="$wire.set('isModalDetailOpen', false)"
                    class="w-full max-w-3xl p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl flex flex-col max-h-[90vh] dark:border-gray-700 dark:bg-gray-900">

                    <div
                        class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Arsip Data Rapor Mentah</h3>
                        <button wire:click="$set('isModalDetailOpen', false)"
                            class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Siswa: <strong
                                class="text-blue-600 dark:text-blue-400 text-base">{{ $nama_siswa_aktif }}</strong></p>
                    </div>

                    <div
                        class="overflow-y-auto p-5 border border-gray-200 rounded-xl bg-gray-50 text-sm dark:bg-gray-800/50 dark:border-gray-700 flex-grow">
                        @if ($detailMentah)
                        <div class="mb-6">
                            <h4
                                class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                                1. Absensi</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-3 gap-3 text-gray-700 dark:text-gray-300">
                                @foreach($detailMentah['absensi'] as $key => $val) <li>{{ strtoupper($key) }}: <strong
                                        class="text-gray-900 dark:text-white">{{ $val }}</strong></li> @endforeach
                            </ul>
                        </div>
                        <div class="mb-6">
                            <h4
                                class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                                2. Capaian Perkembangan</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-3 gap-3 text-gray-700 dark:text-gray-300">
                                @foreach($detailMentah['capaian'] as $key => $val) <li>{{ strtoupper($key) }}: <strong
                                        class="text-gray-900 dark:text-white">{{ $val ?: '-' }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-6">
                            <h4
                                class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                                3. Ekstrakurikuler</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-3 gap-3 text-gray-700 dark:text-gray-300">
                                @foreach($detailMentah['ekstra'] as $key => $val) <li>{{ strtoupper($key) }}: <strong
                                        class="text-gray-900 dark:text-white">{{ $val ?: '-' }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-2">
                            <h4
                                class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                                4. Akademik (Sampel)</h4>
                            <ul
                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-gray-700 dark:text-gray-300">
                                @foreach(array_slice($detailMentah['akademik'], 0, 20) as $key => $val)
                                <li class="truncate" title="{{ strtoupper($key) }}">{{ strtoupper($key) }}: <strong
                                        class="text-gray-900 dark:text-white">{{ $val ?: '-' }}</strong></li>
                                @endforeach
                            </ul>
                            <span class="text-xs text-amber-600 dark:text-amber-400 italic mt-4 block"><i
                                    class="mr-1">ℹ</i> Hanya menampilkan 20 data pertama untuk menghemat memori
                                tampilan.</span>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-32">
                            <p class="text-red-500 font-medium">Arsip data mentah tidak ditemukan untuk siswa ini.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </template>
    </div>
    @endif

    {{-- Modal 2: Edit Manual Penilaian --}}
    @if ($isModalNilai)
    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open"
                class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all">
                <div @click.outside="$wire.set('isModalNilai', false)"
                    class="w-full max-w-xl p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto dark:border-gray-700 dark:bg-gray-900">

                    <div
                        class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Edit Nilai Akhir (Processed)</h3>
                        <button wire:click="$set('isModalNilai', false)"
                            class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">Siswa: <strong
                            class="text-blue-600 dark:text-blue-400 text-base">{{ $nama_siswa_aktif }}</strong>.
                        <br>Ubah huruf rata-rata atau masukkan angka untuk mengubah penilaian (x).
                    </p>

                    <form wire:submit.prevent="simpanManual">
                        <div
                            class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6 dark:bg-gray-800/50 dark:border-gray-700">
                            <!-- Header Form -->
                            <div
                                class="grid grid-cols-12 gap-4 pb-2 mb-2 border-b border-gray-200 dark:border-gray-700 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <div class="col-span-4">Kriteria</div>
                                <div class="col-span-4 text-center">Input Rapor</div>
                                <div class="col-span-4 text-center">Hasil Angka (x)</div>
                            </div>

                            <!-- Looping Kriteria -->
                            @foreach ($kriterias as $k)
                            <div
                                class="grid items-center grid-cols-12 gap-4 py-2.5 border-b border-gray-100 last:border-0 dark:border-gray-700/50">
                                <div class="col-span-4 text-sm font-medium text-gray-700 dark:text-gray-300">{{
                                    $k->nama_kriteria }}</div>
                                <div class="col-span-4">
                                    <input type="text" wire:model.live="inputHuruf.{{ $k->id }}"
                                        placeholder="{{ $k->kode == 'C2' ? 'Ketik Angka' : 'A/B/C/D' }}"
                                        class="w-full px-3 py-1.5 text-center text-sm border border-gray-300 rounded-lg uppercase focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white dark:placeholder-gray-500 transition-shadow">
                                </div>
                                <div class="col-span-4 flex justify-center">
                                    <div
                                        class="min-w-[60px] px-3 py-1.5 font-bold text-blue-700 bg-blue-100 rounded-lg shadow-inner text-center dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $outputAngka[$k->id] ?? 0 }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" wire:click="$set('isModalNilai', false)"
                                class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Batal</button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="simpanManual"
                                class="inline-flex items-center justify-center px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                <svg wire:loading wire:target="simpanManual" class="w-4 h-4 mr-2 animate-spin"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span wire:loading.remove wire:target="simpanManual">Simpan Perubahan</span>
                                <span wire:loading wire:target="simpanManual">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
    @endif

    {{-- Modal Add/Edit Siswa --}}
    @if ($isModalSiswa)
    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open"
                class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all hidden-print">
                <div @click.outside="$wire.set('isModalSiswa', false)"
                    class="w-full max-w-lg p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900">

                    <div
                        class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">
                            {{ $siswa_id ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
                        </h3>
                        <button wire:click="$set('isModalSiswa', false)"
                            class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="simpanSiswa">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="col-span-1 md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Lengkap</label>
                                <input type="text" wire:model="nama_siswa" placeholder="Masukkan nama siswa"
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('nama_siswa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">NIS /
                                    NISN</label>
                                <input type="text" wire:model="nis" placeholder="Nomor Induk"
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('nis') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Jenis
                                    Kelamin</label>
                                <div class="relative z-20 bg-transparent" x-data="{ isOptionSelected: false }">
                                    <select wire:model="jenis_kelamin"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                        @change="isOptionSelected = true">
                                        <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">--
                                            Pilih --</option>
                                        <option value="L">Laki-laki (L)</option>
                                        <option value="P">Perempuan (P)</option>
                                    </select>
                                    <span
                                        class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                                @error('jenis_kelamin') <span class="text-xs text-red-500 mt-1 block">{{ $message
                                    }}</span> @enderror
                            </div>

                            <div>
                                <label
                                    class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                                <input type="text" wire:model="kelas" placeholder="Contoh: Kelas A"
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('kelas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Tahun
                                    Ajaran</label>
                                <input type="text" wire:model="tahun_ajaran" placeholder="Contoh: 2024/2025"
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('tahun_ajaran') <span class="text-xs text-red-500 mt-1 block">{{ $message
                                    }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" wire:click="$set('isModalSiswa', false)"
                                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Batal</button>

                            <button type="submit" wire:loading.attr="disabled" wire:target="simpanSiswa"
                                class="inline-flex items-center justify-center min-w-[120px] px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                <svg wire:loading wire:target="simpanSiswa" class="w-4 h-4 mr-2 animate-spin"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span wire:loading.remove wire:target="simpanSiswa">Simpan Data</span>
                                <span wire:loading wire:target="simpanSiswa">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
    @endif

</div>