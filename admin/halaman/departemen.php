<div class="row">
  <div class="col-12">
    <div class="card" style="width: 100%;">
      <div class="card-body bg-dark text-white">
        <h3 class="card-title">Daftar Departemen</h3>
      </div>
    </div>
  </div>
</div>
<div class="row mt-2 mb-5">
  <div class="col-12">
    <div class="card" style="width: 100%;">
      <div class="card-body table-responsive">
        <?php
        $i = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM departemen");
        ?>
        <a href="#" class="btn btn-outline-dark float-right mb-3 tambah-btn" data-toggle="modal" data-target="#formModal" onclick="changeType('tambah')">
          <i class="fas fa-plus mr-2"></i>Tambah
        </a>
        <table class="table table-hover text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Departemen</th>
              <th scope="col">Kepala Departemen</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($d = mysqli_fetch_assoc($data)) :
            ?>
              <tr>
                <th scope="row"><?= $i ?></th>
                <td><?= $d["nama"] ?></td>
                <td><?= $d["kepala_dept"] ?></td>
                <td>
                  <a href="" class="btn edit-btn" data-id="<?php echo $d["id"]; ?>" data-toggle="modal" data-target="#formModal" onclick="changeType('ubah');">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="" class="btn hapus-btn" data-id="<?php echo $d["id"]; ?>">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
            <?php
              $i++;
            endwhile;
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">Tambah Departemen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="halaman/aksi_departemen.php" method="POST">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="departemen">Nama Departemen</label>
            <input type="text" class="form-control" id="departemen" placeholder="Enter your department.." name="departemen" required>
          </div>
          <div class="form-group">
            <label for="kepala_dept">Kepala Departemen</label>
            <select class="form-control" id="kepala_dept" name="kepala_dept">
              <?php
              $data = mysqli_query($koneksi, "SELECT nama FROM karyawan");
              while ($d = mysqli_fetch_assoc($data)) :
              ?>
                <option value="<?php echo $d["nama"] ?>"><?php echo $d["nama"] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="tambah" id="buttonSubmit">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $(".tambah-btn").on("click", function() {
      $("#departemen").val("");
    });

    $(".edit-btn").on("click", function() {
      var id = $(this).data("id");
      $("#id").val(id);

      $.ajax({
        url: 'halaman/aksi_departemen.php',
        type: 'POST',
        dataType: 'json',
        data: ({
          id: id
        }),
        success: function(data) {
          $("#departemen").val(data.nama);
          $("#kepala_dept").val(data.kepala_dept);
        }
      })
    })

    $(".hapus-btn").on("click", function() {
      if (confirm('Anda yakin untuk menghapus data ini?')) {
        var id = $(this).data("id");

        $.ajax({
          url: 'halaman/aksi_departemen.php',
          type: 'POST',
          dataType: 'json',
          data: ({
            hapus: "",
            id: id
          }),
          success: function(data) {
            alert(data);
          },
          error: function(error) {
            alert(data);
          }
        })
      }
    })
  });

  function changeType(_type) {
    var modalTitle = document.getElementById("formModalLabel");
    var buttonSubmit = document.getElementById("buttonSubmit");

    switch (_type) {
      case 'tambah':
        modalTitle.innerHTML = "Tambah Departemen";
        buttonSubmit.innerHTML = "Tambah";
        buttonSubmit.name = "tambah";
        break;
      case 'ubah':
        modalTitle.innerHTML = "Edit Departemen";
        buttonSubmit.innerHTML = "Edit";
        buttonSubmit.name = "ubah";
        break;
    }
  }
</script>