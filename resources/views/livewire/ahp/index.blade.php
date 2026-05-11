<div>
    <div
        class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] relative">

        <x-loading target="hitungBobot" information="Sedang menghitung Matriks AHP dan Consistency Ratio...." />
        <x-alerts />
        <x-title bigTitle="Perhitungan Bobot Kriteria (AHP)" smallTitle="Bandingkan tingkat kepentingan antar kriteria menggunakan skala Saaty (1-9)." />

        @include('livewire.ahp.hasil-ahp')
        @include('livewire.ahp.input-ahp')

    </div>

    @include('livewire.ahp.detail-ahp')

</div>