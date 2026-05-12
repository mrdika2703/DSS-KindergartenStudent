{{-- Modal 1: Detail Arsip Rapor (Mentah) --}}
@if ($isModalDetailOpen)
<div x-data="{ open: true }" x-show="open">
    <template x-teleport="body">
        <div x-show="open"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 overflow-auto bg-black/60 backdrop-blur-sm transition-all">
            <div @click.outside="$wire.set('isModalDetailOpen', false)"
                class="w-full max-w-3xl p-6 bg-white border border-gray-200 rounded-2xl shadow-2xl flex flex-col max-h-[90vh] dark:border-gray-700 dark:bg-gray-900">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Arsip Data Rapor Mentah</h3>
                    <button wire:click="$set('isModalDetailOpen', false)"
                        class="p-1 text-gray-400 transition-colors rounded-full hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Siswa: <strong
                            class="text-blue-600 dark:text-blue-400 text-base">{{ $nama_siswa_aktif }} / {{ $semester_aktif }}</strong></p>
                </div>

                <div
                    class="overflow-y-auto p-5 border border-gray-200 rounded-xl bg-gray-50 text-sm dark:bg-gray-800/50 dark:border-gray-700 flex-grow">
                    @if ($detailMentah)
                    <div class="mb-6">
                        <h4
                            class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                            1. Absensi</h4>
                        <ul class="grid grid-cols-1 md:grid-cols-3 gap-3 text-gray-700 dark:text-gray-300">
                            @foreach($detailMentah['absensi'] as $key => $val) <li>{{ strtoupper($key) }}: <strong
                                    class="text-gray-900 dark:text-white">{{ $val }}</strong></li> @endforeach
                        </ul>
                    </div>
                    <div class="mb-6">
                        <h4
                            class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                            2. Capaian Perkembangan</h4>
                        <ul class="grid grid-cols-1 md:grid-cols-3 gap-3 text-gray-700 dark:text-gray-300">
                            @foreach($detailMentah['capaian'] as $key => $val) <li>{{ strtoupper($key) }}: <strong
                                    class="text-gray-900 dark:text-white">{{ $val ?: '-' }}</strong></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-6">
                        <h4
                            class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                            3. Ekstrakurikuler</h4>
                        <ul class="grid grid-cols-1 md:grid-cols-3 gap-3 text-gray-700 dark:text-gray-300">
                            @foreach($detailMentah['ekstra'] as $key => $val) <li>{{ strtoupper($key) }}: <strong
                                    class="text-gray-900 dark:text-white">{{ $val ?: '-' }}</strong></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-2">
                        <h4
                            class="font-bold text-blue-700 border-b border-blue-200 pb-2 mb-3 dark:text-blue-400 dark:border-blue-800/50">
                            4. Akademik (Sampel)</h4>
                        <ul
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-gray-700 dark:text-gray-300">
                            @foreach(array_slice($detailMentah['akademik'], 0, 20) as $key => $val)
                            <li class="truncate" title="{{ strtoupper($key) }}">{{ strtoupper($key) }}: <strong
                                    class="text-gray-900 dark:text-white">{{ $val ?: '-' }}</strong></li>
                            @endforeach
                        </ul>
                        <span class="text-xs text-amber-600 dark:text-amber-400 italic mt-4 block"><i class="mr-1">ℹ</i>
                            Hanya menampilkan 20 data pertama untuk menghemat memori
                            tampilan.</span>
                    </div>
                    @else
                    <div class="flex items-center justify-center h-32">
                        <p class="text-red-500 font-medium">Arsip data mentah tidak ditemukan untuk siswa ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </template>
</div>
@endif