<div>
    <div class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] relative min-h-[400px]">
        
        <x-loading target="switchTab, hapusAturan" information="Memuat data..."/>
        <x-alerts />
        <x-title bigTitle="Konfigurasi Fuzzy Tsukamoto" smallTitle="Atur parameter kurva keanggotaan dan basis aturan (Rule Base)." />

        @include('livewire.fuzzy.tabs')

    </div>

    @include('livewire.fuzzy.modal-aturan')
    @include('livewire.fuzzy.modal-himpunan')

</div>