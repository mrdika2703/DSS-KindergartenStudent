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