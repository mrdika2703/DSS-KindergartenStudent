{{-- Modal Add/Edit Siswa --}}
@if ($isModalSiswa)
<div x-data="{ open: true }" x-show="open">
    <template x-teleport="body">
        <div x-show="open"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all hidden-print">
            <div @click.outside="$wire.set('isModalSiswa', false)"
                class="w-full max-w-lg p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl dark:border-gray-700 dark:bg-gray-900">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
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
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
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