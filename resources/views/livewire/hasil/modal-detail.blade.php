{{-- Modal Detail Z --}}
    @if ($isModalDetailOpen && $detailSiswa)

    <div x-data="{ open: true }" x-show="open">
        <template x-teleport="body">
            <div x-show="open"
                class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm hidden-print transition-all">

                <!-- Box Modal dengan styling mirip Main Design -->
                <div @click.outside="$wire.set('isModalDetailOpen', false)"
                    class="w-full max-w-4xl p-6 bg-white border border-gray-200 rounded-2xl shadow-theme-xl max-h-[90vh] overflow-y-auto dark:border-gray-800 dark:bg-gray-900">

                    <!-- Header Modal -->
                    <div
                        class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Transparansi Perhitungan
                            Algoritma</h3>
                        <button wire:click="$set('isModalDetailOpen', false)"
                            class="text-gray-400 transition-colors hover:text-red-500 dark:hover:text-red-400 focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Info Siswa -->
                    <div
                        class="p-4 mb-5 border border-blue-100 rounded-xl bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800/30">
                        <p class="text-gray-700 dark:text-gray-300">
                            Siswa: <strong class="text-blue-700 dark:text-blue-400">{{ $detailSiswa->siswa->nama_siswa
                                }}</strong> |
                            Skor Akhir (Z): <strong class="text-gray-900 dark:text-white">{{
                                number_format($detailSiswa->total_skor_z, 4) }}</strong>
                        </p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Nilai Akhir didapat dari: Σ (Z Kriteria
                            × Bobot AHP)</p>
                    </div>

                    <!-- Grid Perhitungan -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($detailSiswa->rincian as $kriteria_id => $log)

                        @php
                        $dataPenilaian = $detailSiswa->siswa->penilaians->firstWhere('kriteria_id', $kriteria_id);
                        $namaKriteria = $dataPenilaian ? $dataPenilaian->kriteria->nama_kriteria : 'Kriteria ' .
                        $kriteria_id;
                        @endphp

                        <!-- Card Kriteria (Support Dark Mode) -->
                        <div
                            class="p-5 border border-gray-200 rounded-xl bg-gray-50 dark:bg-white/[0.02] dark:border-gray-800">
                            <h4
                                class="pb-2 mb-3 font-bold text-indigo-700 border-b border-indigo-100 dark:text-indigo-400 dark:border-indigo-500/20">
                                {{ $namaKriteria }}
                            </h4>
                            <ul class="mb-4 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                <li>Nilai Asli Siswa (x): <strong class="text-gray-800 dark:text-gray-200">{{
                                        $log['nilai_asli'] }}</strong></li>
                                <li>Bobot Prioritas (AHP): <strong class="text-gray-800 dark:text-gray-200">{{
                                        $log['bobot_ahp'] }}</strong></li>
                            </ul>

                            <div class="overflow-hidden border border-gray-200 rounded-lg dark:border-gray-700">
                                <table class="w-full text-xs text-left">
                                    <thead
                                        class="bg-indigo-50 dark:bg-indigo-900/20 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 font-medium">Rule</th>
                                            <th
                                                class="px-3 py-2 font-medium border-l border-gray-200 dark:border-gray-700">
                                                α (Predikat)</th>
                                            <th
                                                class="px-3 py-2 font-medium border-l border-gray-200 dark:border-gray-700">
                                                Z Rule</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($log['rules'] as $rule)
                                        <tr class="text-gray-600 dark:text-gray-400 bg-white dark:bg-transparent">
                                            <td class="px-3 py-2">IF {{ $rule['himpunan'] }} THEN {{ $rule['kesimpulan']
                                                }}</td>
                                            <td
                                                class="px-3 py-2 font-mono border-l border-gray-200 dark:border-gray-700">
                                                {{ $rule['alpha'] }}</td>
                                            <td
                                                class="px-3 py-2 font-mono border-l border-gray-200 dark:border-gray-700">
                                                {{ $rule['z_rule'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 text-sm font-bold text-right text-gray-800 dark:text-white/90">
                                Z Kriteria Defuzzifikasi = <span class="text-indigo-600 dark:text-indigo-400">{{
                                    $log['z_kriteria'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </template>
    </div>
    @endif