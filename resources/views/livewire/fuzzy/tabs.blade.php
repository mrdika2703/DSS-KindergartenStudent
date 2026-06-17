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
    <div
        class="p-4 mb-5 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-xl dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800/40 flex items-start">
        <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <strong class="font-bold block mb-1">Informasi Pembentukan Kurva:</strong>
            Sesuaikan parameter batas himpunan fuzzy. Parameter <strong>a</strong> (Batas Bawah), <strong>b</strong>
            (Batas Tengah), dan <strong>c</strong> (Batas Atas).
        </div>
    </div>

    <!-- Table Wrapper -->
    <div class="relative min-h-[150px] border border-gray-200 rounded-2xl overflow-hidden dark:border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead
                    class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 font-medium text-theme-sm">Kriteria</th>
                        <th class="px-5 py-3 font-medium text-theme-sm">Himpunan</th>
                        <th class="px-5 py-3 font-medium text-theme-sm text-center">a (Bawah)</th>
                        <th class="px-5 py-3 font-medium text-theme-sm text-center">b (Tengah)</th>
                        <th class="px-5 py-3 font-medium text-theme-sm text-center">c (Atas)</th>
                        {{-- <th class="px-5 py-3 font-medium text-theme-sm text-center w-28">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($dataHimpunan as $h)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm font-semibold text-gray-800 dark:text-white/90">{{
                            $h->kriteria->nama_kriteria }}</td>
                        <td class="px-5 py-4 text-sm">
                            <span
                                class="px-2.5 py-1 text-xs font-bold rounded-lg
                                                {{ $h->nama_himpunan == 'Rendah' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400' : 
                                                  ($h->nama_himpunan == 'Sedang' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400' : 
                                                  'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400') }}">
                                {{ $h->nama_himpunan }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm font-mono text-center text-gray-600 dark:text-gray-400">{{
                            $h->batas_bawah }}</td>
                        <td class="px-5 py-4 text-sm font-mono text-center text-gray-600 dark:text-gray-400">{{
                            $h->batas_tengah ?? '-' }}</td>
                        <td class="px-5 py-4 text-sm font-mono text-center text-gray-600 dark:text-gray-400">{{
                            $h->batas_atas }}</td>
                        {{-- <td class="px-5 py-4 whitespace-nowrap text-center">
                            <button wire:key="btn-edit-himpunan-{{ $h->id }}" wire:click="editHimpunan({{ $h->id }})"
                                wire:loading.attr="disabled" wire:target="editHimpunan({{ $h->id }})"
                                class="inline-flex items-center justify-center min-w-[70px] px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                <svg wire:loading wire:target="editHimpunan({{ $h->id }})"
                                    class="w-3 h-3 mr-1.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span wire:loading.remove wire:target="editHimpunan({{ $h->id }})">Edit Range</span>
                                <span wire:loading wire:target="editHimpunan({{ $h->id }})">Loading...</span>
                            </button>
                        </td> --}}
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6"
                            class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
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
        <div
            class="px-4 py-2 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800/40 w-full sm:w-2/3">
            <strong class="font-bold">Format Aturan:</strong> <span class="font-mono text-xs">IF (Kriteria) is
                (Himpunan) THEN (Kesimpulan)</span>
        </div>
        {{-- <button wire:click="bukaModalAturan" wire:loading.attr="disabled"
            class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Tambah Aturan
        </button> --}}
    </div>

    <!-- Table Wrapper -->
    <div class="relative min-h-[150px] border border-gray-200 rounded-2xl overflow-hidden dark:border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead
                    class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 font-medium text-theme-sm w-20">ID</th>
                        <th class="px-5 py-3 font-medium text-theme-sm">Kriteria Terkait</th>
                        <th class="px-5 py-3 font-medium text-theme-sm">Logika (IF ... THEN)</th>
                        {{-- <th class="px-5 py-3 font-medium text-theme-sm text-center w-36">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($dataAturan as $a)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm font-bold text-gray-800 dark:text-gray-300">{{ $a->kode_aturan }}
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $a->nama_kriteria }}</td>
                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                            <span
                                class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 font-bold text-xs mr-1 text-gray-600 dark:text-gray-400">IF</span>
                            <span class="font-medium text-blue-600 dark:text-blue-400">{{ $a->nama_kriteria }}</span>
                            <span class="mx-1 text-gray-500">is</span>
                            <span class="font-bold underline decoration-blue-300 dark:decoration-blue-700">{{
                                $a->nama_himpunan }}</span>
                            <span
                                class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 font-bold text-xs mx-1 text-gray-600 dark:text-gray-400">THEN</span>
                            <span class="font-bold text-green-600 dark:text-green-400">{{ $a->kesimpulan }}</span>
                        </td>
                        {{-- <td class="px-5 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Edit Button -->
                                <button wire:key="btn-edit-aturan-{{ $a->id }}"
                                    wire:click="bukaModalAturan({{ $a->id }})" wire:loading.attr="disabled"
                                    wire:target="bukaModalAturan({{ $a->id }})"
                                    class="inline-flex items-center justify-center min-w-[60px] px-2 py-1.5 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-md hover:bg-yellow-200 dark:bg-yellow-500/20 dark:text-yellow-400 dark:hover:bg-yellow-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                    <span wire:loading.remove wire:target="bukaModalAturan({{ $a->id }})">Edit</span>
                                    <span wire:loading wire:target="bukaModalAturan({{ $a->id }})">Wait</span>
                                </button>

                                <!-- Delete Button -->
                                <button wire:key="btn-hapus-aturan-{{ $a->id }}" wire:click="hapusAturan({{ $a->id }})"
                                    wire:confirm="Yakin ingin menghapus aturan {{ $a->kode_aturan }} ini?"
                                    wire:loading.attr="disabled" wire:target="hapusAturan({{ $a->id }})"
                                    class="inline-flex items-center justify-center min-w-[65px] px-2 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200 dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500/30 transition-colors disabled:opacity-70 disabled:cursor-wait">
                                    <span wire:loading.remove wire:target="hapusAturan({{ $a->id }})">Hapus</span>
                                    <span wire:loading wire:target="hapusAturan({{ $a->id }})">Wait</span>
                                </button>
                            </div>
                        </td> --}}
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4"
                            class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
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