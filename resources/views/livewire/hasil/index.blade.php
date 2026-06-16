<div>
    <div class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        
        <x-loading target="prosesPerankingan" information="Mesin Inferensi sedang menghitung Z-Score dan Perankingan..."/>
        <x-alerts />
        <x-title bigTitle="Hasil Perhitungan" smallTitle="Setelah memasukkan excel, halaman ini digunakan untuk proses perhitungan akhir." />

        @include('livewire.hasil.card-proses')
        @include('livewire.hasil.table')
        
    </div>

    @include('livewire.hasil.modal-detail')

    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }

            body {
                background-color: white !important;
            }

            .shadow-md {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>

</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        // HANYA untuk membuka tab baru saat URL berhasil dibuat
        Livewire.on('buka-tab-cetak', (event) => {
            window.open(event.url, '_blank');
        });
    });
</script>