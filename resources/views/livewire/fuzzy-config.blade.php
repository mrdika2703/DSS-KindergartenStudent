<div>
    <div class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] relative min-h-[400px]">
        
        {{-- Loading Overlay Full Screen untuk proses berat --}}
        <div wire:loading wire:target="switchTab, hapusAturan">
            <div class="absolute inset-0 z-[50] flex items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm rounded-2xl transition-all duration-300">
                <div class="p-4 bg-white rounded-2xl shadow-xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex flex-col items-center">
                    <svg class="w-10 h-10 mb-3 text-blue-600 dark:text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Memuat Data...</span>
                </div>
            </div>
        </div>

        {{-- Floating Alerts (Toasts) --}}
        <div class="fixed top-20 right-5 z-[999999] flex flex-col gap-3 pointer-events-none hidden-print">
            <!-- Alert Sukses -->
            @if (session()->has('pesan'))
            <div wire:key="alert-success-{{ time() }}" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="flex items-center w-full max-w-sm p-4 bg-green-50 border border-green-200 shadow-xl pointer-events-auto rounded-xl dark:bg-green-900/40 dark:border-green-800/60">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-green-600 bg-green-200/50 rounded-lg dark:bg-green-800/50 dark:text-green-400">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" /></svg>
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
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" /></svg>
                </div>
                <div class="ms-3 text-sm font-semibold text-red-800 dark:text-red-200">{{ session('error') }}</div>
                <button @click="show = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-red-600 hover:text-red-900 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200/50 inline-flex items-center justify-center h-8 w-8 dark:text-red-400 dark:hover:text-white dark:hover:bg-red-800/50 transition-colors">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg>
                </button>
            </div>
            @endif
        </div>

        {{-- Main Title --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white/90">Konfigurasi Fuzzy Tsukamoto</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Atur parameter kurva keanggotaan dan basis aturan (Rule Base).</p>
        </div>

        {{-- Tabs Menu --}}
        <div class="flex mb-6 border-b border-gray-200 dark:border-gray-700">
            <button wire:click="switchTab('himpunan')" 
                class="px-5 py-3 font-semibold text-sm transition-colors duration-200 {{ $tabAktif == 'himpunan' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-gray-300' }}">
                A. Batas Kurva Kriteria (Input)
            </button>
            <button wire:click="switchTab('aturan')" 
                class="px-5 py-3 font-semibold text-sm transition-colors duration-200 {{ $tabAktif == 'aturan' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-gray-300' }}">
                B. Aturan Tsukamoto (Rule Base)
            </button>
        </div>

        {{-- TAB A: HIMPUNAN --}}
        @if ($tabAktif == 'himpunan')
            <div>
                <!-- Info Alert -->
                <div class="p-4 mb-5 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-xl dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800/40 flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <strong class="font-bold block mb-1">Informasi Pembentukan Kurva:</strong>
                        Sesuaikan parameter batas himpunan fuzzy. Parameter <strong>a</strong> (Batas Bawah), <strong>b</strong> (Batas Tengah), dan <strong>c</strong> (Batas Atas).
                    </div>
                </div>

                <!-- Table Wrapper -->
                <div class="relative min-h-[150px] border border-gray-200 rounded-2xl overflow-hidden dark:border-gray-800">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-auto">
                            <thead class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium text-theme-sm">Kriteria</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm">Himpunan</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm text-center">a (Bawah)</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm text-center">b (Tengah)</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm text-center">c (Atas)</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm text-center w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($dataHimpunan as $h)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                        <td class="px-5 py-4 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $h->kriteria->nama_kriteria }}</td>
                                        <td class="px-5 py-4 text-sm">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg
                                                {{ $h->nama_himpunan == 'Rendah' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400' : 
                                                  ($h->nama_himpunan == 'Sedang' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400' : 
                                                  'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400') }}">
                                                {{ $h->nama_himpunan }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-mono text-center text-gray-600 dark:text-gray-400">{{ $h->batas_bawah }}</td>
                                        <td class="px-5 py-4 text-sm font-mono text-center text-gray-600 dark:text-gray-400">{{ $h->batas_tengah ?? '-' }}</td>
                                        <td class="px-5 py-4 text-sm font-mono text-center text-gray-600 dark:text-gray-400">{{ $h->batas_atas }}</td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            <button wire:key="btn-edit-himpunan-{{ $h->id }}" wire:click="editHimpunan({{ $h->id }})" wire:loading.attr="disabled" wire:target="editHimpunan({{ $h->id }})"
                                                class="inline-flex items-center justify-center min-w-[70px] px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                                <svg wire:loading wire:target="editHimpunan({{ $h->id }})" class="w-3 h-3 mr-1.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                <span wire:loading.remove wire:target="editHimpunan({{ $h->id }})">Edit Range</span>
                                                <span wire:loading wire:target="editHimpunan({{ $h->id }})">Loading...</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
                                            Data Himpunan Kosong. Silakan periksa Database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- TAB B: ATURAN --}}
        @if ($tabAktif == 'aturan')
            <div>
                <!-- Action Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                    <div class="px-4 py-2 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800/40 w-full sm:w-2/3">
                        <strong class="font-bold">Format Aturan:</strong> <span class="font-mono text-xs">IF (Kriteria) is (Himpunan) THEN (Kesimpulan)</span>
                    </div>
                    <button wire:click="bukaModalAturan" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Aturan
                    </button>
                </div>

                <!-- Table Wrapper -->
                <div class="relative min-h-[150px] border border-gray-200 rounded-2xl overflow-hidden dark:border-gray-800">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-auto">
                            <thead class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium text-theme-sm w-20">ID</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm">Kriteria Terkait</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm">Logika (IF ... THEN)</th>
                                    <th class="px-5 py-3 font-medium text-theme-sm text-center w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($dataAturan as $a)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                        <td class="px-5 py-4 text-sm font-bold text-gray-800 dark:text-gray-300">{{ $a->kode_aturan }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $a->nama_kriteria }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            <span class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 font-bold text-xs mr-1 text-gray-600 dark:text-gray-400">IF</span> 
                                            <span class="font-medium text-blue-600 dark:text-blue-400">{{ $a->nama_kriteria }}</span> 
                                            <span class="mx-1 text-gray-500">is</span> 
                                            <span class="font-bold underline decoration-blue-300 dark:decoration-blue-700">{{ $a->nama_himpunan }}</span> 
                                            <span class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 font-bold text-xs mx-1 text-gray-600 dark:text-gray-400">THEN</span> 
                                            <span class="font-bold text-green-600 dark:text-green-400">{{ $a->kesimpulan }}</span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <!-- Edit Button -->
                                                <button wire:key="btn-edit-aturan-{{ $a->id }}" wire:click="bukaModalAturan({{ $a->id }})" wire:loading.attr="disabled" wire:target="bukaModalAturan({{ $a->id }})"
                                                    class="inline-flex items-center justify-center min-w-[60px] px-2 py-1.5 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-md hover:bg-yellow-200 dark:bg-yellow-500/20 dark:text-yellow-400 dark:hover:bg-yellow-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                                    <span wire:loading.remove wire:target="bukaModalAturan({{ $a->id }})">Edit</span>
                                                    <span wire:loading wire:target="bukaModalAturan({{ $a->id }})">Wait</span>
                                                </button>

                                                <!-- Delete Button -->
                                                <button wire:key="btn-hapus-aturan-{{ $a->id }}" wire:click="hapusAturan({{ $a->id }})" wire:confirm="Yakin ingin menghapus aturan {{ $a->kode_aturan }} ini?" wire:loading.attr="disabled" wire:target="hapusAturan({{ $a->id }})"
                                                    class="inline-flex items-center justify-center min-w-[65px] px-2 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200 dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                                    <span wire:loading.remove wire:target="hapusAturan({{ $a->id }})">Hapus</span>
                                                    <span wire:loading wire:target="hapusAturan({{ $a->id }})">Wait</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
                                            Belum ada aturan yang dibuat.
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

    {{-- MODAL HIMPUNAN (TELEPORT) --}}
    @if ($isModalHimpunanOpen)
    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open" class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all hidden-print">
                <div @click.outside="$wire.set('isModalHimpunanOpen', false)" class="w-full max-w-lg p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900">
                    
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Edit Parameter Kurva</h3>
                        <button wire:click="$set('isModalHimpunanOpen', false)" class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="mb-5 p-3 rounded-lg bg-gray-50 border border-gray-100 dark:bg-white/[0.02] dark:border-gray-800">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Kriteria: <strong class="text-gray-900 dark:text-white">{{ $himpunan_kriteria_nama }}</strong> <br>
                            Himpunan: <strong class="text-blue-600 dark:text-blue-400">{{ $nama_himpunan }}</strong>
                        </p>
                    </div>
                    
                    <form wire:submit.prevent="simpanHimpunan">
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block mb-1.5 text-xs font-bold text-gray-700 dark:text-gray-300">a (Batas Bawah)</label>
                                <input type="number" step="0.01" wire:model="batas_bawah" 
                                    class="w-full h-11 px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow text-center font-mono">
                                @error('batas_bawah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-xs font-bold text-gray-700 dark:text-gray-300">b (Batas Tengah)</label>
                                <input type="number" step="0.01" wire:model="batas_tengah" 
                                    class="w-full h-11 px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow text-center font-mono">
                                @error('batas_tengah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-xs font-bold text-gray-700 dark:text-gray-300">c (Batas Atas)</label>
                                <input type="number" step="0.01" wire:model="batas_atas" 
                                    class="w-full h-11 px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow text-center font-mono">
                                @error('batas_atas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" wire:click="$set('isModalHimpunanOpen', false)" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Batal</button>
                            
                            <button type="submit" wire:loading.attr="disabled" wire:target="simpanHimpunan" class="inline-flex items-center justify-center min-w-[120px] px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                <svg wire:loading wire:target="simpanHimpunan" class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span wire:loading.remove wire:target="simpanHimpunan">Simpan</span>
                                <span wire:loading wire:target="simpanHimpunan">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
    @endif

    {{-- MODAL ATURAN (TELEPORT) --}}
    @if ($isModalAturanOpen)
    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open" class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all hidden-print">
                <div @click.outside="$wire.set('isModalAturanOpen', false)" class="w-full max-w-xl p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900">
                    
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">
                            {{ $aturan_id ? 'Edit Aturan' : 'Tambah Aturan Baru' }}
                        </h3>
                        <button wire:click="$set('isModalAturanOpen', false)" class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="simpanAturan">
                        <div class="mb-5">
                            <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Kode Aturan <span class="text-gray-400 font-normal">(Contoh: R1)</span></label>
                            <input type="text" wire:model="kode_aturan" placeholder="R1" 
                                class="w-full h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow">
                            @error('kode_aturan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-5 mb-5 border border-blue-200 rounded-xl bg-blue-50/50 dark:bg-blue-900/10 dark:border-blue-800/40">
                            <span class="block mb-3 text-sm font-bold text-blue-800 dark:text-blue-400">Kondisi (IF)</span>
                            <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3">
                                <select wire:model="aturan_kriteria_id" class="w-full sm:w-1/2 h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow shadow-sm">
                                    <option value="">-- Pilih Kriteria --</option>
                                    @foreach ($kriterias as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kriteria }}</option>
                                    @endforeach
                                </select>
                                
                                <span class="font-medium text-gray-500 dark:text-gray-400">is</span>
                                
                                <select wire:model="aturan_himpunan" class="w-full sm:w-1/2 h-11 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow shadow-sm">
                                    <option value="">-- Pilih Himpunan --</option>
                                    <option value="Rendah">Rendah</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Tinggi">Tinggi</option>
                                </select>
                            </div>
                            @error('aturan_kriteria_id') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
                            @error('aturan_himpunan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-green-700 dark:text-green-400">Kesimpulan (THEN)</label>
                            <select wire:model="kesimpulan" class="w-full h-11 px-4 py-2 border-2 border-green-300 rounded-lg bg-green-50 text-green-800 text-sm font-semibold focus:ring-2 focus:ring-green-500/50 focus:border-green-500 dark:bg-green-900/20 dark:border-green-600 dark:text-green-300 transition-shadow shadow-sm">
                                <option value="">-- Pilih Output --</option>
                                <option value="Sangat Terampil">Sangat Terampil</option>
                                <option value="Cukup Terampil">Cukup Terampil</option>
                            </select>
                            @error('kesimpulan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" wire:click="$set('isModalAturanOpen', false)" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Batal</button>
                            
                            <button type="submit" wire:loading.attr="disabled" wire:target="simpanAturan" class="inline-flex items-center justify-center min-w-[140px] px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                <svg wire:loading wire:target="simpanAturan" class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span wire:loading.remove wire:target="simpanAturan">Simpan Aturan</span>
                                <span wire:loading wire:target="simpanAturan">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
    @endif
</div>