<div wire:loading wire:target="{{ $target ?? '' }}">

    <!-- Bungkus UI untuk memastikan posisi di tengah layar secara paksa -->
    <div
        class="fixed inset-0 top-0 left-0 z-[999999] flex items-center justify-center w-screen h-screen bg-black/60 backdrop-blur-sm">

        <!-- Card Loading Ukuran Sedang -->
        <div
            class="flex flex-col items-center justify-center p-8 mx-4 bg-white border border-gray-200 shadow-2xl rounded-2xl dark:bg-gray-800 dark:border-gray-700 w-full max-w-sm">

            <!-- Spinner Animation -->
            <svg class="w-14 h-14 mb-5 text-blue-600 dark:text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>

            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Memproses</h3>
            <span class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 leading-relaxed">
                {{ $information ?? 'Sedang memproses data, mohon tunggu...' }}
            </span>
        </div>

    </div>
</div>