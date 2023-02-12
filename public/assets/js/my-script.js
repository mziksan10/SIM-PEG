// TABEL ID
$(document).ready( function () {
    $('#myTable').DataTable();
} );
$(document).ready( function () {
    $('#tetapTable').DataTable();
} );
$(document).ready( function () {
    $('#kontrakTable').DataTable();
} );

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#nip" ).autocomplete({
    source: function( request, response ) {
      // Fetch data
      $.ajax({
        url:"/cari-pegawai",
        type: 'post',
        dataType: "json",
        data: {
           _token: CSRF_TOKEN,
           search: request.term
        },
        success: function( data ) {
           response( data );
        }
      });
    },
    select: function (event, ui) {
       // Set selection
       $('#nip').val(ui.item.label); // display the selected text
       $('#nip').val(ui.item.value); // save selected id to input
    }
  });

});

// Script kondisi pemilihan bidang & jabatan
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#bidang_id').on('change', function () {
        $.ajax({
            url: '/cari-jabatan',
            method: 'POST',
            data: {bidang_id: $(this).val()},
            success: function (response) {
                $('#jabatan_id').empty();
                $.each(response, function (id, nama_jabatan) {
                    $('#jabatan_id').append(new Option(nama_jabatan, id))
                });

            }
        });

    });
    
});

// Script kondisi pemilihan bidang & jabatan ketika Edit
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#bidang_id_').on('change', function () {
        $.ajax({
            url: '/cari-jabatan',
            method: 'POST',
            data: {bidang_id: $(this).val()},
            success: function (response) {
                $('#jabatan_id_').empty();
                $.each(response, function (id, nama_jabatan) {
                    $('#jabatan_id_').append(new Option(nama_jabatan, id))
                });

            }
        });

    });
    
});

// Script kondisi pemilihan pegawai & golongan
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#nip').on('change', function () {
        $.ajax({
            url: '/cari-golongan',
            method: 'POST',
            data: {nip: $(this).val()},
            success: function (response) {
                $('#golongan_id').empty();

                $.each(response, function (key, entry) {
                    $('#golongan_id').append(new Option(entry.golongan + ' - ' + entry.status, entry.id))
                })
            }
        })
    });
});

// Script kondisi pemilihan provinsi & kabupaten/kota
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#provinsi').on('change', function () {
        $.ajax({
            url: '/cari-kota',
            method: 'POST',
            data: {provinsi: $(this).val()},
            success: function (response) {
                $('#kab_kota').empty();
                $('#kab_kota').append(new Option('Pilih..', ''));


                $.each(response, function (key, entry) {
                    $('#kab_kota').append(new Option(entry.city_name, entry.city_id))
                })
            }
        })
    });
});

// Script kondisi pemilihan kota & kecamatan
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#kab_kota').on('change', function () {
        $.ajax({
            url: '/cari-kecamatan',
            method: 'POST',
            data: {kab_kota: $(this).val()},
            success: function (response) {
                $('#kecamatan').empty();
                $('#kecamatan').append(new Option('Pilih..', ''));

                $.each(response, function (key, entry) {
                    $('#kecamatan').append(new Option(entry.dis_name, entry.dis_id))
                })
            }
        })
    });
});

// Script kondisi pemilihan kecamatan & desa
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#kecamatan').on('change', function () {
        $.ajax({
            url: '/cari-desa',
            method: 'POST',
            data: {kecamatan: $(this).val()},
            success: function (response) {
                $('#desa').empty();
                $('#desa').append(new Option('Pilih..', ''));

                $.each(response, function (key, entry) {
                    $('#desa').append(new Option(entry.subdis_name, entry.subdis_id))
                })
            }
        })
    });
});

// JAM ID
window.onload = function() { jam(); }
        
function jam() {
    var e = document.getElementById('jam'),
    d = new Date(), h, m, s;
    h = d.getHours();
    m = set(d.getMinutes());
    s = set(d.getSeconds());

    e.innerHTML = h +':'+ m +':'+ s;

    setTimeout('jam()', 1000);
}

function set(e) {
    e = e < 10 ? '0'+ e : e;
    return e;
}