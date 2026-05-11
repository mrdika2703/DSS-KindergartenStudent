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
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
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
                <svg wire:loading wire:target="fileExcel, importExcel" class="w-5 h-5 mr-2 text-white animate-spin"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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