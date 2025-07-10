$(document).ready(function() {
    // Inisialisasi DataTables
    $('#main-table').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "order": [], // Opsional: nonaktifkan pengurutan awal
    });

    // Event handler untuk memicu Modal AJAX
    $('body').on('click', '.btn-modal', function() {
        const url = $(this).data('url');
        // Gunakan .load() untuk mengambil konten dan memasukkannya ke modal
        $('#main-modal .modal-content').load(url, function() {
            // Tampilkan modal setelah konten berhasil dimuat
            $('#main-modal').modal('show');
        });
    });

    // Event handler untuk menampilkan nama file saat upload
    $('body').on('change', '.custom-file-input', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});

// 4. Fungsi untuk Konfirmasi Hapus dengan SweetAlert
function deleteConfirmation(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form hapus jika dikonfirmasi
            document.getElementById('delete-form-' + id).submit();
        }
    });
}