<div>
    <div class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] relative">
        
        {{-- Loading Overlay Full Screen (Proses Berat) --}}
        <div wire:loading wire:target="resetDataSiswa, simpanSiswa, hapusSiswa, switchTab">
            <div class="fixed inset-0 top-0 left-0 z-[999999] flex items-center justify-center w-screen h-screen bg-black/60 backdrop-blur-sm">
                <div class="flex flex-col items-center justify-center p-8 mx-4 bg-white border border-gray-200 shadow-2xl rounded-2xl dark:bg-gray-800 dark:border-gray-700 w-full max-w-sm">
                    <svg class="w-14 h-14 mb-5 text-blue-600 dark:text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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
            <h2 class="mb-2 text-2xl font-bold text-gray-800 dark:text-white/90">Data Siswa</h2>
            <p class="mb-6 text-gray-600 dark:text-gray-400">Upload excel penilaian dengan template yang disediakan lalu sistem akan masuk ke perhitungan praproses.</p>
        </div>

        {{-- Floating Alerts (Toasts) --}}
        <div class="fixed top-20 right-5 z-[999999] flex flex-col gap-3 pointer-events-none hidden-print">
            <!-- Alert Sukses -->
            @if (session()->has('pesan'))
            <div wire:key="alert-success-{{ time() }}" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="flex items-center w-full max-w-sm p-4 bg-green-50 border border-green-200 shadow-xl pointer-events-auto rounded-xl dark:bg-green-900/40 dark:border-green-800/60">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-green-600 bg-green-200/50 rounded-lg dark:bg-green-800/50 dark:text-green-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                </div>
                <div class="ms-3 text-sm font-semibold text-green-800 dark:text-green-200">{{ session('pesan') }}</div>
                <button @click="show = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-green-600 hover:text-green-900 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200/50 inline-flex items-center justify-center h-8 w-8 dark:text-green-400 dark:hover:text-white dark:hover:bg-green-800/50 transition-colors">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg>
                </button>
            </div>
            @endif

            <!-- Alert Error -->
            @if (session()->has('error'))
            <div wire:key="alert-error-{{ time() }}" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="flex items-center w-full max-w-sm p-4 bg-red-50 border border-red-200 shadow-xl pointer-events-auto rounded-xl dark:bg-red-900/40 dark:border-red-800/60">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-red-600 bg-red-200/50 rounded-lg dark:bg-red-800/50 dark:text-red-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                </div>
                <div class="ms-3 text-sm font-semibold text-red-800 dark:text-red-200">{{ session('error') }}</div>
                <button @click="show = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-red-600 hover:text-red-900 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200/50 inline-flex items-center justify-center h-8 w-8 dark:text-red-400 dark:hover:text-white dark:hover:bg-red-800/50 transition-colors">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg>
                </button>
            </div>
            @endif
        </div>

        {{-- Tabs Menu --}}
        <div class="flex mb-6 border-b border-gray-200 dark:border-gray-700">
            <button wire:click="switchTab('siswa')" 
                class="px-5 py-3 font-semibold text-sm transition-colors duration-200 {{ $tabAktif == 'siswa' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Data Siswa
            </button>
            <button wire:click="switchTab('kriteria')" 
                class="px-5 py-3 font-semibold text-sm transition-colors duration-200 {{ $tabAktif == 'kriteria' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Data Kriteria
            </button>
        </div>

        {{-- TAB: DATA SISWA --}}
        @if ($tabAktif == 'siswa')
            <div x-data="{ showConfirmModal: false, deleteId: null }" >
                <!-- Modal Konfirmasi -->
            <template x-teleport="body">
                <div x-show="showConfirmModal" style="display: none;" class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-opacity"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    
                    <div @click.outside="showConfirmModal = false" class="w-full max-w-sm p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900 transform transition-all"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full dark:bg-red-900/30">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mb-2 text-lg font-bold text-center text-gray-800 dark:text-white/90">Hapus Data Siswa?</h3>
                        <p class="mb-6 text-sm text-center text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat dibatalkan. Semua nilai terkait siswa ini akan dihapus permanen.</p>
                        
                        <div class="flex justify-center space-x-3">
                            <button @click="showConfirmModal = false" type="button" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors w-1/2">
                                Batal
                            </button>
                            <button @click="$wire.hapusSiswa(deleteId); showConfirmModal = false" type="button" class="px-4 py-2.5 text-sm font-bold text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition-colors w-1/2">
                                Ya, Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </template>

                <!-- Action & Filter Bar -->
                <div class="p-4 mb-6 rounded-2xl border border-gray-200 bg-blue-50 dark:border-gray-800 dark:bg-blue-950/50 flex flex-col lg:flex-row items-center justify-between gap-4">
                    
                    <div class="flex flex-wrap gap-2 w-full lg:w-auto">
                        <button wire:click="bukaModal" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition whitespace-nowrap">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Siswa
                        </button>
                        
                        <!-- Menggunakan wire:confirm untuk UX konfirmasi yang lebih baik di Livewire -->
                        <button wire:click="resetDataSiswa" wire:confirm="PERINGATAN KERAS!\n\nApakah Anda yakin ingin MENGHAPUS SELURUH DATA SISWA? Seluruh nilai rapor, hasil AHP, dan peringkat akan ikut terhapus secara permanen."
                            class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg shadow hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition whitespace-nowrap">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Reset Data
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        <select wire:model.live="filterKelas" class="h-[42px] rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 shadow-sm w-full sm:w-40">
                            <option value="">Semua Kelas</option>
                            @foreach($listKelas as $lk) <option value="{{ $lk }}">{{ $lk }}</option> @endforeach
                        </select>

                        <select wire:model.live="filterTahunAjaran" class="h-[42px] rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 shadow-sm w-full sm:w-44">
                            <option value="">Semua Tahun</option>
                            @foreach($listTahun as $lt) <option value="{{ $lt }}">{{ $lt }}</option> @endforeach
                        </select>

                        <div class="relative w-full sm:w-56">
                            <button type="button" class="absolute -translate-y-1/2 left-3 top-1/2">
                                <svg class="fill-gray-500 dark:fill-gray-400" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" fill="" />
                                </svg>
                            </button>
                            <input type="text" wire:model.live.debounce.300ms="searchSiswa" placeholder="Cari NIS / Nama..."
                                class="h-[42px] w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>
                    </div>
                </div>

                <!-- Table Wrapper with Local Loading -->
                <div class="relative min-h-[200px] border border-gray-200 rounded-2xl overflow-hidden dark:border-gray-800">
                    
                    <!-- Table Loading Blur (Tbody Only) -->
                    <div wire:loading wire:target="searchSiswa, filterKelas, filterTahunAjaran, gotoPage, previousPage, nextPage">
                        <div class="absolute left-0 right-0 bottom-0 top-12 z-50 flex justify-center items-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm transition-all duration-300">
                            <div class="p-3 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                <svg class="w-10 h-10 text-blue-600 dark:text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-auto">
                            <thead class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3 font-medium text-center w-12 text-theme-sm">No</th>
                                    <th class="px-4 py-3 font-medium text-theme-sm">NIS</th>
                                    <th class="px-4 py-3 font-medium text-theme-sm">Nama Siswa</th>
                                    <th class="px-4 py-3 font-medium text-center text-theme-sm">L/P</th>
                                    <th class="px-4 py-3 font-medium text-theme-sm">Kelas</th>
                                    <th class="px-4 py-3 font-medium text-theme-sm">Tahun Ajaran</th>
                                    <th class="px-4 py-3 font-medium text-center text-theme-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($dataSiswa as $index => $s)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                        <td class="px-4 py-4 text-center text-sm text-gray-600 dark:text-gray-400">{{ $dataSiswa->firstItem() + $index }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 font-mono">{{ $s->nis }}</td>
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $s->nama_siswa }}</td>
                                        <td class="px-4 py-4 text-center text-sm text-gray-600 dark:text-gray-400">{{ $s->jenis_kelamin }}</td>
                                        <td class="px-4 py-4 text-sm">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg font-medium text-xs dark:bg-blue-900/30 dark:text-blue-400">{{ $s->kelas ?? '-' }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $s->tahun_ajaran ?? '-' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <!-- Edit Button -->
                                                <button wire:key="btn-edit-{{ $s->id }}" wire:click="editSiswa({{ $s->id }})" wire:loading.attr="disabled" wire:target="editSiswa({{ $s->id }})"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-yellow-700 bg-yellow-100 rounded-md hover:bg-yellow-200 dark:bg-yellow-500/20 dark:text-yellow-400 dark:hover:bg-yellow-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                                    <svg wire:loading wire:target="editSiswa({{ $s->id }})" class="w-3 h-3 mr-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                    <svg wire:loading.remove wire:target="editSiswa({{ $s->id }})" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" /> </svg>
                                                </button>

                                                <!-- Delete Button -->
                                                <button wire:key="btn-hapus-{{ $s->id }}" @click="deleteId = {{ $s->id }}; showConfirmModal = true"
                                                title="Hapus Penilaian"
                                                class="inline-flex items-center justify-center w-8 h-8 text-red-700 bg-red-100 rounded-md hover:bg-red-200 dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500/30 transition-colors disabled:opacity-70 disabled:cursor-not-allowed">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
                                            Data siswa tidak ditemukan untuk filter ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4 px-2">
                    {{ $dataSiswa->links() }}
                </div>
            </div>
        @endif

        {{-- TAB: DATA KRITERIA --}}
        @if ($tabAktif == 'kriteria')
            <div>
                <!-- Action Bar -->
                <div class="flex justify-end mb-4">
                    <div class="relative w-full sm:w-64">
                        <button type="button" class="absolute -translate-y-1/2 left-3 top-1/2">
                            <svg class="fill-gray-500 dark:fill-gray-400" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" fill="" />
                            </svg>
                        </button>
                        <input type="text" wire:model.live.debounce.300ms="searchKriteria" placeholder="Cari Kriteria..." 
                            class="h-[42px] w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="p-4 mb-6 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-xl dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800/40 flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <strong class="font-bold block mb-1">Informasi Sistem:</strong>
                        Tabel ini memastikan kriteria (Akademik, Absensi, Capaian Perkembangan, Ekstrakurikuler) yang digunakan dalam DSS sudah sesuai dengan yang telah ditetapkan.
                    </div>
                </div>

                <!-- Table Wrapper with Local Loading -->
                <div class="relative min-h-[150px] border border-gray-200 rounded-2xl overflow-hidden dark:border-gray-800">
                    
                    <div wire:loading wire:target="searchKriteria">
                        <div class="absolute left-0 right-0 bottom-0 top-12 z-50 flex justify-center items-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm transition-all duration-300">
                            <div class="p-3 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                <svg class="w-10 h-10 text-blue-600 dark:text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-auto">
                            <thead class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3 font-medium text-center w-12 text-theme-sm">No</th>
                                    <th class="px-4 py-3 font-medium text-theme-sm">Kode</th>
                                    <th class="px-4 py-3 font-medium text-theme-sm">Nama Kriteria</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($dataKriteria as $index => $k)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                        <td class="px-4 py-4 text-center text-sm text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 text-sm font-bold text-blue-600 dark:text-blue-400">{{ $k->kode }}</td>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-white/90">{{ $k->nama_kriteria }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
                                            Data kriteria kosong. Silakan jalankan Seeder.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- Modal Add/Edit Siswa --}}
    @if ($isModalOpen)
    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open" class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all hidden-print">
                <div @click.outside="$wire.set('isModalOpen', false)" class="w-full max-w-lg p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900">
                    
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">
                            {{ $siswa_id ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
                        </h3>
                        <button wire:click="tutupModal" class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="simpanSiswa">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="col-span-1 md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                                <input type="text" wire:model="nama_siswa" placeholder="Masukkan nama siswa" 
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('nama_siswa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">NIS / NISN</label>
                                <input type="text" wire:model="nis" placeholder="Nomor Induk" 
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('nis') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
                                <select wire:model="jenis_kelamin" 
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki (L)</option>
                                    <option value="P">Perempuan (P)</option>
                                </select>
                                @error('jenis_kelamin') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                                <input type="text" wire:model="kelas" placeholder="Contoh: Kelas A" 
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('kelas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Ajaran</label>
                                <input type="text" wire:model="tahun_ajaran" placeholder="Contoh: 2024/2025" 
                                    class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                                @error('tahun_ajaran') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" wire:click="tutupModal" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Batal</button>
                            
                            <button type="submit" wire:loading.attr="disabled" wire:target="simpanSiswa" class="inline-flex items-center justify-center min-w-[120px] px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                <svg wire:loading wire:target="simpanSiswa" class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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