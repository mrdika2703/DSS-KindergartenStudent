<!-- Form Input Matriks AHP -->
<div class="mt-5">
    <div class="p-5 border border-gray-200 rounded-2xl bg-gray-50 dark:bg-white/[0.02] dark:border-gray-800 self-start">

        <h3 class="mb-5 text-lg font-bold text-gray-800 dark:text-white/90 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                </path>
            </svg>
            Input Matriks Perbandingan
        </h3>

        <form wire:submit.prevent="hitungBobot">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-2">
                @foreach ($kriterias as $i => $k1)
                @foreach ($kriterias as $j => $k2)
                @if ($i < $j) <div>
                    <label
                        class="flex items-center justify-center w-full mb-2.5 text-sm font-bold text-gray-800 dark:text-gray-200 bg-blue-50 border border-blue-100 py-2.5 rounded-lg shadow-sm dark:bg-blue-900/20 dark:border-blue-800/30">
                        <span class="text-blue-700 dark:text-blue-400">{{ $k1->nama_kriteria }}</span>
                        <span class="text-gray-400 dark:text-gray-500 mx-3 text-xs">VS</span>
                        <span class="text-blue-700 dark:text-blue-400">{{ $k2->nama_kriteria }}</span>
                    </label>

                    <div class="relative z-20 bg-transparent" x-data="{ isOptionSelected: false }">
                        <select wire:model="inputMatriks.{{ $k1->id }}.{{ $k2->id }}"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true">

                            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                Pilih Tingkat Kepentingan
                            </option>

                            <optgroup label="Pilih jika [{{ $k1->nama_kriteria }}] Lebih Penting:">
                                <option value="9">9 - Mutlak Sangat Penting ({{ $k1->nama_kriteria }})
                                </option>
                                <option value="8">8 - Mendekati Mutlak ({{ $k1->nama_kriteria }})</option>
                                <option value="7">7 - Sangat Penting ({{ $k1->nama_kriteria }})</option>
                                <option value="6">6 - Mendekati Sangat Penting ({{ $k1->nama_kriteria }})
                                </option>
                                <option value="5">5 - Lebih Penting ({{ $k1->nama_kriteria }})</option>
                                <option value="4">4 - Mendekati Lebih Penting ({{ $k1->nama_kriteria }})
                                </option>
                                <option value="3">3 - Sedikit Lebih Penting ({{ $k1->nama_kriteria }})
                                </option>
                                <option value="2">2 - Mendekati Sedikit Lebih Penting ({{ $k1->nama_kriteria
                                    }})</option>
                            </optgroup>

                            <optgroup label="Seimbang:">
                                <option value="1">1 - Keduanya Sama Penting</option>
                            </optgroup>

                            <optgroup label="Pilih jika [{{ $k2->nama_kriteria }}] Lebih Penting:">
                                <option value="0.5">2 - Mendekati Sedikit Lebih Penting ({{
                                    $k2->nama_kriteria }})</option>
                                <option value="0.3333">3 - Sedikit Lebih Penting ({{ $k2->nama_kriteria }})
                                </option>
                                <option value="0.25">4 - Mendekati Lebih Penting ({{ $k2->nama_kriteria }})
                                </option>
                                <option value="0.2">5 - Lebih Penting ({{ $k2->nama_kriteria }})</option>
                                <option value="0.1667">6 - Mendekati Sangat Penting ({{ $k2->nama_kriteria
                                    }})</option>
                                <option value="0.1428">7 - Sangat Penting ({{ $k2->nama_kriteria }})
                                </option>
                                <option value="0.125">8 - Mendekati Mutlak ({{ $k2->nama_kriteria }})
                                </option>
                                <option value="0.1111">9 - Mutlak Sangat Penting ({{ $k2->nama_kriteria }})
                                </option>
                            </optgroup>
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
            @endif
            @endforeach
            @endforeach
    </div>
    <button type="submit" wire:loading.attr="disabled" wire:target="hitungBobot"
        class="w-full flex items-center justify-center px-5 py-3 mt-6 text-sm font-bold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors disabled:opacity-70 disabled:cursor-wait">
        <svg wire:loading wire:target="hitungBobot" class="w-4 h-4 mr-2 animate-spin text-white"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        <span wire:loading.remove wire:target="hitungBobot">Hitung Bobot & Cek Konsistensi</span>
        <span wire:loading wire:target="hitungBobot">Sedang Menghitung...</span>
    </button>
    </form>
</div>