 <!--   Core JS Files   -->
 <script src="{{ asset ('assets/js/core/jquery-3.7.1.min.js')}}"></script>
 <script src="{{ asset ('assets/js/core/popper.min.js')}}"></script>
 <script src="{{ asset ('assets/js/core/bootstrap.min.js')}}"></script>

 <!-- jQuery Scrollbar -->
 <script src="{{ asset ('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

 <!-- Chart JS -->
 <script src="{{ asset ('assets/js/plugin/chart.js/chart.min.js')}}"></script>

 <!-- jQuery Sparkline -->
 <script src="{{ asset ('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

 <!-- Chart Circle -->
 <script src="{{ asset ('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

 <!-- Datatables -->
 <script src="{{ asset ('assets/js/plugin/datatables/datatables.min.js')}}"></script>

 <!-- Bootstrap Notify -->
 {{-- <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> --}}

 <!-- jQuery Vector Maps -->
 <script src="{{ asset ('assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
 <script src="{{ asset ('assets/js/plugin/jsvectormap/world.js')}}"></script>

 <!-- Sweet Alert -->
 <script src="{{ asset ('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

 <!-- Kaiadmin JS -->
 <script src="{{ asset ('assets/js/kaiadmin.min.js')}}"></script>

 <!-- Kaiadmin DEMO methods, don't include it in your project! -->
 <script src="{{ asset ('assets/js/setting-demo.js')}}"></script>
 <script src="{{ asset ('assets/js/demo.js')}}"></script>

 <script>
   $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
     type: "line",
     height: "70",
     width: "100%",
     lineWidth: "2",
     lineColor: "#177dff",
     fillColor: "rgba(23, 125, 255, 0.14)",
   });

   $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
     type: "line",
     height: "70",
     width: "100%",
     lineWidth: "2",
     lineColor: "#f3545d",
     fillColor: "rgba(243, 84, 93, .14)",
   });

   $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
     type: "line",
     height: "70",
     width: "100%",
     lineWidth: "2",
     lineColor: "#ffa534",
     fillColor: "rgba(255, 165, 52, .14)",
   });
 </script>
<script>
  $(document).ready(function () {
  
    // untuk tampilan table
    $("#table").DataTable({
      pageLength: 5,
      searching: true, // Mengaktifkan fitur pencarian
      language: {
        search: "Cari:", // Mengubah label pencarian
        lengthMenu: "Tampilkan _MENU_ entri per halaman",
        zeroRecords: "Tidak ada hasil yang ditemukan",
        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
        infoEmpty: "Tidak ada entri tersedia",
        infoFiltered: "(difilter dari _MAX_ total entri)",
      },
      // Tambahkan pengaturan lain jika diperlukan
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Menyembunyikan pesan sukses setelah 5 detik
      const successMessage = document.getElementById('success-message');
      if (successMessage) {
          setTimeout(function() {
              successMessage.style.display = 'none'; // Sembunyikan pesan setelah 5 detik
          }, 5000); // 5000 ms = 5 detik
      }

      // Menyembunyikan pesan kesalahan setelah 5 detik
      const errorMessage = document.getElementById('error-message');
      if (errorMessage) {
          setTimeout(function() {
              errorMessage.style.display = 'none'; // Sembunyikan pesan setelah 5 detik
          }, 5000); // 5000 ms = 5 detik
      }
  });
</script>
{{-- <script type="text/javascript">
  $(document).ready(function() {
      $('#nama_kategori').on('change', function() {
          var kategoriId = $(this).val();
          if (kategoriId) {
              $.ajax({
                  url: '/getKategoriDetails/' + kategoriId,
                  type: 'GET',
                  dataType: 'json',
                  success: function(data) {
                      if (data) {
                          // Isi dropdown Jenis Kategori
                          $('#jenis_kategori').empty();
                          $('#jenis_kategori').append('<option value="">Pilih Jenis Kategori</option>');
                          $('#jenis_kategori').append('<option value="' + data.id_kategori + '">' + data.jenis_kategori + '</option>');

                          // Isi dropdown Lokasi Buku
                          $('#lokasi_buku').empty();
                          $('#lokasi_buku').append('<option value="">Pilih Lokasi Buku</option>');
                          $('#lokasi_buku').append('<option value="' + data.id_kategori + '">' + data.lokasi_buku + '</option>');
                      }
                  }
              });
          } else {
              $('#jenis_kategori').empty();
              $('#jenis_kategori').append('<option value="">Pilih Jenis Kategori</option>');
              $('#lokasi_buku').empty();
              $('#lokasi_buku').append('<option value="">Pilih Lokasi Buku</option>');
          }
      });
  });
</script> --}}



