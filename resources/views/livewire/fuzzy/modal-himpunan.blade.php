{{-- MODAL HIMPUNAN (TELEPORT) --}}
@if ($isModalHimpunanOpen)
<div x-data="{ open: true }" x-show="open">
    <template x-teleport="body">
        <div x-show="open"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all hidden-print">
            <div @click.outside="$wire.set('isModalHimpunanOpen', false)"
                class="w-full max-w-lg p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Edit Parameter Kurva</h3>
                    <button wire:click="$set('isModalHimpunanOpen', false)"
                        class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div
                    class="mb-5 p-3 rounded-lg bg-gray-50 border border-gray-100 dark:bg-white/[0.02] dark:border-gray-800">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Kriteria: <strong class="text-gray-900 dark:text-white">{{ $himpunan_kriteria_nama }}</strong>
                        <br>
                        Himpunan: <strong class="text-blue-600 dark:text-blue-400">{{ $nama_himpunan }}</strong>
                    </p>
                </div>

                <form wire:submit.prevent="simpanHimpunan">
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 dark:text-gray-300">a (Batas
                                Bawah)</label>
                            <input type="number" step="0.01" wire:model="batas_bawah"
                                class="w-full h-11 px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow text-center font-mono">
                            @error('batas_bawah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 dark:text-gray-300">b (Batas
                                Tengah)</label>
                            <input type="number" step="0.01" wire:model="batas_tengah"
                                class="w-full h-11 px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow text-center font-mono">
                            @error('batas_tengah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 dark:text-gray-300">c (Batas
                                Atas)</label>
                            <input type="number" step="0.01" wire:model="batas_atas"
                                class="w-full h-11 px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition-shadow text-center font-mono">
                            @error('batas_atas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <button type="button" wire:click="$set('isModalHimpunanOpen', false)"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Batal</button>

                        <button type="submit" wire:loading.attr="disabled" wire:target="simpanHimpunan"
                            class="inline-flex items-center justify-center min-w-[120px] px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors disabled:opacity-70 disabled:cursor-wait">
                            <svg wire:loading wire:target="simpanHimpunan" class="w-4 h-4 mr-2 animate-spin"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
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