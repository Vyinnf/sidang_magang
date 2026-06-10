// public/js/confirmations.js

document.addEventListener("DOMContentLoaded", function () {
    // Pastikan objek 'Swal' (SweetAlert2) tersedia secara global (dari CDN)
    if (typeof Swal !== "undefined") {
        document.querySelectorAll("form").forEach((form) => {
            const deleteButton = form.querySelector(
                'button[type="submit"][title="Hapus"]'
            );
            if (deleteButton) {
                deleteButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Mencegah form submit default

                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Tindakan ini tidak dapat dibatalkan! Data akan dihapus secara permanen.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33", // Merah untuk "Hapus"
                        cancelButtonColor: "#3085d6", // Biru untuk "Batal"
                        confirmButtonText: "Ya, Hapus Data!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Lanjutkan submit form jika pengguna mengkonfirmasi
                        }
                    });
                });
            }
        });
    }
});
