function changeURL() {
    const title = document.querySelector("#title");
    const slug = document.querySelector("#slug");

    title.addEventListener("keyup", function () {
        let preslug = title.value;
        preslug = preslug.replace(/ /g, "-");
        slug.value = preslug.toLowerCase();
    });
}

const toast = document.querySelector('div[aria-describedby="swal2-html-container"]');
if (toast) {
    toast.addEventListener("mouseenter", Swal.stopTimer)
    toast.addEventListener("mouseleave", Swal.resumeTimer)
}

function confirmDeleteOrNot(element, section, text = "Tindakan ini tidak dapat diurungkan") {
    Swal.fire({
        title: 'Anda yakin ingin menghapus ' + section + ' ini?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus ' + section + '!',
        cancelButtonText: 'Batalkan'
    }).then((result) => {
        if (result.isConfirmed) {
            element.submit();
        } else {
            Swal.fire(
                'Dibatalkan',
                section[0].toUpperCase() + section.substring(1) + ' anda tidak jadi dihapus.',
                'error'
            )
        }
    })
}

function restoreFromTrashConfirmation(element) {
    Swal.fire({
        title: 'Anda yakin ingin mengembelikan artikel ini dari tempat sampah?',
        text: 'Ini akan mengubah status artikel ke "draft"',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, kembalikan ke draft!',
        cancelButtonText: 'Batalkan'
    }).then((result) => {
        if (result.isConfirmed) {
            element.submit();
        } else {
            Swal.fire(
                'Dibatalkan',
                'Artikel anda tidak jadi dikembalikan dari tempat sampah.',
                'error'
            )
        }
    })
}

function preventPaste() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 7000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'error',
        title: 'Dilarang mem-paste!'
    })
    return false;
}

function previewImage() {
    const image = document.querySelector("#image");
    const preview = document.querySelector(".img-preview");
    const btnDeleteImg = document.querySelector("#btn-delete-image");

    preview.style.display = "block";

    const ofReader = new FileReader();
    ofReader.readAsDataURL(image.files[0]);

    // Check file type
    if (image.files[0].type.match('image/*')) {
        ofReader.onload = function (oFREvent) {
            preview.src = oFREvent.target.result;
            btnDeleteImg.style.display = "block";
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Harap hanya upload gambar!'
        })
        preview.src = "";
        btnDeleteImg.style.display = "none";
    }
}

function deleteImage(e) {
    const preview = document.querySelector(".img-preview");
    Swal.fire({
        title: 'Anda yakin ingin menghapus gambar ini?',
        text: "Tindakan ini tidak dapat diurungkan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus gambar!',
        cancelButtonText: 'Batalkan',
        showLoaderOnConfirm: true,
        // Jika pencet ok
        preConfirm: () => {
            // Buka url untuk menghapus gambar, jika berhasil akan memasukkan value yang di dapat dari respon jsonnya ke variabel 'result'
            return fetch(window.location.href + "/delete-image")
                .then(response => response.json())
                // Jika fetchnya gagal  
                .catch(error => {
                    Swal.fire(
                        'Gagal',
                        'Gambar gagal dihapus.',
                        'error'
                    )
                })
        },
        // Tidak boleh keluar dari pop up kecuali jika loadingnya selesai
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        // 'result' variabel yang berisi data apakah diklik atau tidak, dsb, dan juga berisi tentang hasil yang didapat dari API jika ada
        if (result.value) {
            if (result.value.status === "success") {
                Swal.fire(
                    'Berhasil',
                    'Gambar berhasil dihapus.',
                    'success'
                )
            } else {
                Swal.fire(
                    'Gagal',
                    'Gambar gagal dihapus.',
                    'error'
                )
            }
            // Hide src attribut
            preview.src = "";
            e.style.display = "none";
        } else if (result.isConfirmed === false) {
            Swal.fire(
                'Dibatalkan',
                'Gambar anda tidak jadi dihapus.',
                'error'
            )
        } else {
            Swal.fire(
                'Error',
                'Terjadi error, silakan coba lagi.',
                'error'
            )
        }
    })
}

function publish(status = "published") {
    const form = document.querySelector("#form");
    const input = document.querySelector("#status");
    input.setAttribute("value", status);
    form.submit();
}

document.addEventListener('trix-attachment-add', function (e) {
    // Upload image using ajax
    const image = e.attachment.file;
    var data = new FormData()
    data.append('image', image)

    fetch(window.location.origin + '/dashboard/artikel/add-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').getAttribute('value')
            },
            body: data
        })
        .then(response => response.json())
        .then(data => {
            e.attachment.setAttributes({
                url: data.url
            });
        })
})
