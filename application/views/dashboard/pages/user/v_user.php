<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'product') echo 'active' ?>">User Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="card-title">List of users</h5>
                            </div>
                            <div class="col-lg-6 text-end">
                                <!-- <a href="<?= base_url('dashboard/user/add') ?>" class="btn btn-primary mt-3">Add new</a> -->

                                <!-- Vertically centered Modal -->
                                <button type="button" class="btn btn-primary mt-3" onclick="add()">
                                    <!-- <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#verticalycentered"> -->
                                    Add new user
                                </button>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <!-- End Table with stripped rows -->
                            <table id="table-user" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Company</th>
                                        <th>Act.</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <div class="modal fade" id="addUser" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserTitle">sdadasdsa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetAttr()"></button>
                </div>
                <form class="row g-3" action="#" id="formAdd">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-body">

                        <!-- Vertical Form -->
                        <div class="col-12">
                            <label for="yourName" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="yourName" value="<?= set_value('name') ?>">
                        </div>

                        <div class="col-12">
                            <label for="yourEmail" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" id="yourEmail" value="<?= set_value('email') ?>">
                        </div>

                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <input type="text" name="username" class="form-control" id="yourUsername" value="<?= set_value('username') ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="yourPhone" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" id="yourphone_number" value="<?= set_value('phone_number') ?>">
                        </div>

                        <div class="col-12">
                            <label for="yourPassword1" class="form-label">Password</label>
                            <input type="password" name="password1" class="form-control" id="password1">
                        </div>

                        <div class="col-12">
                            <label for="yourPassword2" class="form-label">Confirmation Password</label>
                            <input type="password" name="password2" class="form-control" id="password2">
                        </div>
                        <div class="col-12">
                            <label for="yourCompany" class="form-label">Company</label>
                            <select name="company" id="company" class="form-select">
                                <option value="">--Choose company</option>
                                <?php
                                foreach ($partners as $p) {
                                ?>
                                    <option value="<?= $p->Id ?>"><?= $p->nama ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="yourRole" class="form-label">Role</label>
                            <select name="member_role" id="member_role" class="form-select">
                                <option value="">--Choose role</option>
                                <?php
                                foreach ($roles as $r) {
                                ?>
                                    <option value="<?= $r->Id ?>"><?= $r->role ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetAttr()">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSave" onclick="save()">Save changes</button>
                    </div>
                </form><!-- Vertical Form -->
            </div>
        </div>
    </div><!-- End Vertically centered Modal-->

</main><!-- End #main -->

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    var tableUser = '#table-user';

    var saveData;
    var modal = '#addUser';
    var formAdd = '#formAdd';
    var modalTitle = '#addUserTitle';
    var btnSave = '#btnSave';

    // fungsi menampilkan form tambah data user
    function add() {
        saveData = "tambah";

        $(formAdd)[0].reset();
        $(modal).modal("show");
        $(modalTitle).text("Add new user");
    }

    // fungsi proses simpan data user
    function save() {
        $(btnSave).text('Wait...').attr('disabled', true);

        if (saveData == "tambah") {
            url = "<?= base_url('dashboard/user/add') ?>";
        } else if (saveData == "edit") {
            url = "<?= base_url('dashboard/user/update') ?>";
        } else if (saveData == "change") {
            url = "<?= base_url('dashboard/user/change_password') ?>";
        }

        $.ajax({
            type: "POST",
            url: url,
            data: $(formAdd).serialize(),
            dataType: "JSON",
            success: function(response) {
                var message = response.message;
                if (response.status == "success") {
                    $(modal).modal('hide');

                    reloadTable();
                    swal_success(message);
                    $(btnSave).text('Save changes').attr('disabled', false);

                } else {
                    $(modal).modal('hide');

                    reloadTable();
                    swal_error(message);
                    $(btnSave).text('Save changes').attr('disabled', false);
                }
            },
            error: function(response) {
                // reloadTable();
                console.log(response.message);

                Swal.fire({
                    title: "Error!! ",
                    text: response.message,
                    icon: "error",
                });
            }
        });
    }

    // fungsi menampilkan form edit data user
    function edit(id, type) {
        if (type == 'edit') {
            saveData = 'edit';
            $(formAdd)[0].reset();
        }

        $.ajax({
            type: "GET",
            url: "<?= base_url('dashboard/user/edit/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                $(modalTitle).text("Update user");
                $(btnSave).text('Update');
                $(btnSave).attr('disabled', false);
                $('[name="id"]').val(response.Id);
                $('[name="name"]').val(response.name);
                $('[name="username"]').val(response.username);
                $('[name="email"]').val(response.email);
                $('[name="phone_number"]').val(response.phone_number);
                $('[name="company"]').val(response.id_perusahaan);
                $('[name="member_role"]').val(response.role_id);
                $('label[for="yourPassword1"]').hide();
                $('[name="password1"]').attr('hidden', true);
                $('label[for="yourPassword2"]').hide();
                $('[name="password2"]').attr('hidden', true);

                $(modal).modal('show');

            }
        });
    }

    // fungsi reset atribut saat tombol close diklik
    function resetAttr() {
        $('label[for="yourName"]').show();
        $('[name="name"]').attr('hidden', false);
        $('label[for="yourUsername"]').show();
        $('[name="username"]').attr('hidden', false);
        $('label[for="yourEmail"]').show();
        $('[name="email"]').attr('hidden', false);
        $('label[for="yourPhone"]').show();
        $('[name="phone_number"]').attr('hidden', false);
        $('label[for="yourCompany"]').show();
        $('[name="company"]').attr('hidden', false);
        $('label[for="yourRole"]').show();
        $('[name="member_role"]').attr('hidden', false);
        $('label[for="yourPassword1"]').show();
        $('[name="password1"]').attr("hidden", false);
        $('label[for="yourPassword2"]').show();
        $('#inputGroupPrepend').show();
        $('[name="password2"]').attr("hidden", false);
    }

    function change_password(id, type) {
        if (type == 'change') {
            saveData = 'change';
            $(formAdd)[0].reset();
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('dashboard/user/edit/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                $(modalTitle).text("Reset password");
                $(btnSave).text('Reset password');
                $(btnSave).attr('disabled', false);
                $('[name="id"]').val(response.Id);
                $('label[for="yourName"]').hide();
                $('[name="name"]').attr('hidden', true);
                $('label[for="yourUsername"]').hide();
                $('[name="username"]').attr('hidden', true);
                $('label[for="yourEmail"]').hide();
                $('[name="email"]').attr('hidden', true);
                $('label[for="yourPhone"]').hide();
                $('[name="phone_number"]').attr('hidden', true);
                $('label[for="yourCompany"]').hide();
                $('[name="company"]').attr('hidden', true);
                $('label[for="yourRole"]').hide();
                $('[name="member_role"]').attr('hidden', true);
                $('#inputGroupPrepend').hide();

                $(modal).modal('show');
            }
        });
    }
    // datatable menampilkan data user
    new DataTable(tableUser, {
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url('dashboard/user/getData'); ?>",
            "type": "POST"
        },
        "columnDefs": [-1],
        "orderable": false
    });
</script>