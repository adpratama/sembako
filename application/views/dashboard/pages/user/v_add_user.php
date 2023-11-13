<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/user">User Management</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'user') echo 'active' ?>"><?= $title ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <?php
            if ($this->uri->segment(4) == true) {
            ?>
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit User Data</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" action="<?= base_url('dashboard/user/update/' . $user_detail["username"]) ?>" method="POST">
                                <div class="col-12">
                                    <label for="yourName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= $user_detail["name"] ?>">
                                </div>

                                <div class="col-12">
                                    <label for="yourEmail" class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" id="yourEmail" value="<?= $user_detail['email'] ?>">
                                </div>

                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input type="text" name="username" class="form-control" id="yourUsername" value="<?= $user_detail['username'] ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="yourName" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" id="yourphone_number" value="<?= $user_detail['phone_number'] ?>" placeholder="Enter your phone number">
                                </div>
                                <div class="col-12">
                                    <label for="inputCategory" class="form-label">Role</label>
                                    <select name="member_role" id="member_role" class="form-select">
                                        <option value="">-- Choose role</option>
                                        <option value="1" <?php if ($user_detail['role_id'] == "1") echo "selected"; ?>>Administrator</option>
                                        <option value="2" <?php if ($user_detail['role_id'] == "2") echo "selected"; ?>>Member</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputCategory" class="form-label">Is Active</label>
                                    <select name="is_active" id="is_active" class="form-select">
                                        <option value="">-- Choose Status</option>
                                        <option value="1" <?php if ($user_detail['is_active'] == "1") echo "selected"; ?>>Active</option>
                                        <option value="0" <?php if ($user_detail['is_active'] == "0") echo "selected"; ?>>Nonactive</option>
                                    </select>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="<?= base_url('dashboard/user') ?>" class="btn btn-secondary">Back</a>
                                </div>
                            </form><!-- Vertical Form -->

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Change password</h5>

                            <?= $this->session->flashdata('message_name'); ?>

                            <form action="<?= base_url('auth/change_password/' . $user['username']) ?>" class="row g-3" method="post">

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input type="password" name="password1" class="form-control" id="password1">
                                    <?= form_error('password1', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Confirmation Password</label>
                                    <input type="password" name="password2" class="form-control" id="password2">
                                    <?= form_error('password2', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add New Member</h5>

                            <?= $this->session->flashdata('message_name'); ?>

                            <!-- Vertical Form -->
                            <form class="row g-3" action="<?= base_url('dashboard/user/add') ?>" method="POST" enctype="multipart/form-data">
                                <div class="col-12">
                                    <label for="yourName" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="yourName" value="<?= set_value('name') ?>">
                                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-12">
                                    <label for="yourEmail" class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" id="yourEmail" value="<?= set_value('email') ?>">
                                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input type="text" name="username" class="form-control" id="yourUsername" value="<?= set_value('username') ?>">
                                    </div>
                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-12">
                                    <label for="yourName" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" id="yourphone_number" value="<?= set_value('phone_number') ?>">
                                    <?= form_error('phone_number', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input type="password" name="password1" class="form-control" id="password1">
                                    <?= form_error('password1', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Confirmation Password</label>
                                    <input type="password" name="password2" class="form-control" id="password2">
                                    <?= form_error('password2', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-12">
                                    <label for="inputCategory" class="form-label">Role</label>
                                    <select name="member_role" id="member_role" class="form-select">
                                        <option value="">--Choose role</option>
                                        <option value="1">Administrator</option>
                                        <option value="2">Member</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                </div>
                            </form><!-- Vertical Form -->

                        </div>
                    </div>
                </div>
            <?php
            } ?>
        </div>
    </section>

</main><!-- End #main -->