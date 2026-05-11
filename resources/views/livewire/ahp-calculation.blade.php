<div>
    <div
        class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] relative">

        {{-- Loading Overlay Full Screen --}}
        <div wire:loading wire:target="hitungBobot">
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
                        Sedang menghitung Matriks AHP<br>dan Consistency Ratio...
                    </span>
                </div>
            </div>
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

        {{-- Header Page --}}
        <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white/90 mb-1">Perhitungan Bobot Kriteria (AHP)</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Bandingkan tingkat kepentingan antar kriteria
                menggunakan skala Saaty (1-9).</p>
        </div>


        <div>
            @if ($sudahDihitung)
            <div
                class="p-5 border border-gray-200 rounded-2xl bg-white dark:bg-white/[0.02] dark:border-gray-800 self-start shadow-sm transition-all">

                <h3 class="mb-5 text-lg font-bold text-gray-800 dark:text-white/90 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Hasil & Validasi
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    <div
                        class="flex flex-col items-center justify-center p-6 text-center border rounded-xl {{ $isKonsisten ? 'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800/40' : 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800/40' }}">
                        <span
                            class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-3 uppercase tracking-wide">
                            Consistency Ratio (CR)
                        </span>

                        <div>
                            <span
                                class="inline-flex items-center px-4 py-2 mb-3 text-2xl font-black rounded-xl {{ $isKonsisten ? 'text-green-800 bg-green-200 dark:bg-green-500/20 dark:text-green-400' : 'text-red-800 bg-red-200 dark:bg-red-500/20 dark:text-red-400' }}">
                                {{ number_format($cr, 4) }}

                                @if($isKonsisten)
                                <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @endif
                            </span>
                        </div>

                        <span
                            class="text-sm font-bold {{ $isKonsisten ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                            @if($isKonsisten)
                            Nilai CR < 0.1 (Data Diterima) @else Nilai CR> 0.1 (Data Ditolak)
                                @endif
                        </span>
                    </div>

                    <div
                        class="lg:col-span-2 overflow-hidden border border-gray-200 rounded-xl dark:border-gray-700 bg-white dark:bg-gray-900/50">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left table-auto">
                                <thead
                                    class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                                    <tr>
                                        <th class="px-5 py-3.5 font-medium text-theme-sm">Kriteria</th>
                                        <th class="px-5 py-3.5 font-medium text-theme-sm">Bobot Prioritas (W)</th>
                                        <th class="px-5 py-3.5 font-medium text-theme-sm">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($kriterias as $k)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                        <td class="px-5 py-3.5 text-sm font-semibold text-gray-800 dark:text-white/90">
                                            {{ $k->nama_kriteria }}
                                        </td>
                                        <td
                                            class="px-5 py-3.5 text-sm font-mono font-medium text-gray-600 dark:text-gray-400">
                                            {{ number_format($bobotEigen[$k->id], 4) }}
                                        </td>
                                        <td
                                            class="px-5 py-3.5 text-sm font-mono font-bold text-blue-600 dark:text-blue-400">
                                            {{ number_format($bobotEigen[$k->id] * 100, 2) }}%
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="mt-5">
                    @if(!$isKonsisten)
                    <div
                        class="p-4 text-sm text-red-700 bg-red-50 border-l-4 border-red-500 rounded-r-lg dark:bg-red-900/20 dark:text-red-400 shadow-sm">
                        Karena matriks tidak konsisten, bobot <strong class="font-bold">tidak disimpan</strong>. Harap
                        ubah kembali penilaian Anda di form sebelah kiri agar lebih logis.
                    </div>
                    @else
                    <div
                        class="p-4 text-sm text-green-700 bg-green-50 border-l-4 border-green-500 rounded-r-lg dark:bg-green-900/20 dark:text-green-400 shadow-sm">
                        Bobot telah diverifikasi dan otomatis disimpan ke database untuk digunakan pada perhitungan
                        algoritma selanjutnya.
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="mt-5">
                <div
                    class="p-5 border border-gray-200 rounded-2xl bg-gray-50 dark:bg-white/[0.02] dark:border-gray-800 self-start">

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
                                            <option value="0.5">2 - Mendekati Sedikit Lebih Penting ({{ $k2->nama_kriteria }})</option>
                                            <option value="0.3333">3 - Sedikit Lebih Penting ({{ $k2->nama_kriteria }})</option>
                                            <option value="0.25">4 - Mendekati Lebih Penting ({{ $k2->nama_kriteria }})</option>
                                            <option value="0.2">5 - Lebih Penting ({{ $k2->nama_kriteria }})</option>
                                            <option value="0.1667">6 - Mendekati Sangat Penting ({{ $k2->nama_kriteria }})</option>
                                            <option value="0.1428">7 - Sangat Penting ({{ $k2->nama_kriteria }})</option>
                                            <option value="0.125">8 - Mendekati Mutlak ({{ $k2->nama_kriteria }})</option>
                                            <option value="0.1111">9 - Mutlak Sangat Penting ({{ $k2->nama_kriteria }})</option>
                                        </optgroup>
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

        </div>
    </div>
</div>

{{-- Detail Matriks Awal --}}
@if ($sudahDihitung)
<div class="mt-5 pt-6 border-t border-gray-200 dark:border-gray-800">
    <h3 class="mb-4 text-lg font-bold text-gray-800 dark:text-white/90">Detail Matriks Perbandingan Awal</h3>

    <div class="overflow-hidden border border-gray-200 rounded-xl dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full text-center table-auto">
                <thead
                    class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 font-medium text-theme-sm border-r border-gray-200 dark:border-gray-700">
                            Kriteria</th>
                        @foreach ($kriterias as $k)
                        <th class="px-4 py-3 font-medium text-theme-sm">{{ $k->kode }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($kriterias as $k1)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td
                            class="px-4 py-3 text-sm font-bold text-gray-800 dark:text-white/90 bg-gray-50 dark:bg-white/[0.02] border-r border-gray-200 dark:border-gray-700">
                            {{ $k1->kode }}</td>
                        @foreach ($kriterias as $k2)
                        <td class="px-4 py-3 text-sm font-mono text-gray-600 dark:text-gray-400">
                            {{ number_format($matriksAwal[$k1->id][$k2->id], 3) }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr class="bg-indigo-50 dark:bg-indigo-900/20 border-t-2 border-gray-200 dark:border-gray-700">
                        <td
                            class="px-4 py-3 text-sm font-bold text-indigo-800 dark:text-indigo-300 border-r border-gray-200 dark:border-gray-700">
                            TOTAL</td>
                        @foreach ($kriterias as $k)
                        <td class="px-4 py-3 text-sm font-bold font-mono text-indigo-700 dark:text-indigo-400">{{
                            number_format($jumlahKolom[$k->id], 3) }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
</div>
</div>