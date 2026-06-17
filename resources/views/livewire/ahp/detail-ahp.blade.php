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
                        <th class="px-4 py-3 font-medium text-theme-sm">{{ $k->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($kriterias as $k1)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td
                            class="px-4 py-3 text-sm font-bold text-gray-800 dark:text-white/90 bg-gray-50 dark:bg-white/[0.02] border-r border-gray-200 dark:border-gray-700">
                            {{ $k1->nama_kriteria }}</td>
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