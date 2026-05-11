{{-- Modal 2: Edit Manual Penilaian --}}
@if ($isModalNilai)
<div x-data="{ open: true }" x-show="open">
    <template x-teleport="body">
        <div x-show="open"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all">
            <div @click.outside="$wire.set('isModalNilai', false)"
                class="w-full max-w-xl p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto dark:border-gray-700 dark:bg-gray-900">

                <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-gray-800">
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