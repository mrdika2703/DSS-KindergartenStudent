<!-- Hasil Perhitungan Bobot AHP -->
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
            <span class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-3 uppercase tracking-wide">
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
                            <td class="px-5 py-3.5 text-sm font-mono font-medium text-gray-600 dark:text-gray-400">
                                {{ number_format($bobotEigen[$k->id], 4) }}
                            </td>
                            <td class="px-5 py-3.5 text-sm font-mono font-bold text-blue-600 dark:text-blue-400">
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