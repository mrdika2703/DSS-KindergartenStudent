<div>
    <div
        class="p-6 rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] relative">

        <x-loading target="switchTab, importExcel, bukaModal, unduhTemplate, eksekusiReset, hapusPenilaian, simpanManual, hapusSiswa" information="Harap tunggu sebentar, data sedang diproses..."/>
        <x-alerts />
        <x-title bigTitle="Manajemen Penilaian Siswa" smallTitle="Upload excel penilaian dengan template yang disediakan lalu sistem akan masuk ke perhitungan praproses." />

        @include('livewire.penilaian.tabs')
        @include('livewire.penilaian.table')

    </div>
    
    @include('livewire.penilaian.modal-rapot')
    @include('livewire.penilaian.modal-edit-nilai')
    @include('livewire.penilaian.modal-edit-siswa')

</div>