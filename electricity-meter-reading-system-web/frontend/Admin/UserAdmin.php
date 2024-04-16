<title>Add User</title>
<link rel="stylesheet" href="../../style/StyleUser.css">
<?php include('..\login_check.php'); ?>

<body>
    <?php include('./NavbarAdmin.php'); ?>
    <div class="head">
        <button id="head-btn" disabled>Add User</button>
    </div>
    <div class="form">
        <form>
            <div class="row1">
                <div class="box-input">
                    <label>Meter ID</label>
                    <input type="text" id="user_meter_id" name="user_meter_id" required>
                </div>
                <div class="box-input">
                    <label>PEA ID</label>
                    <input type="text" id="user_pea_id" name="user_pea_id" required>
                </div>
            </div>
            <div class="row2">
                <div class="box-input">
                    <label>First Name</label>
                    <input type="text" id="user_first_name" name="user_first_name" required>
                </div>
                <div class="box-input">
                    <label>Last Name</label>
                    <input type="text" id="user_last_name" name="user_last_name" required>
                </div>
            </div>
            <div class="row3">
                <div class="box-input">
                    <label>Phone</label>
                    <input type="text" id="user_phone" name="user_phone" required>
                </div>
                <div class="box-input">
                    <label>Email</label>
                    <input type="text" id="user_email" name="user_email" required>
                </div>
            </div>
            <div class="row4">
                <div class="box-input">
                    <label>Username</label>
                    <input type="text" id="user_username" name="user_username" required>
                </div>
                <div class="box-input">
                    <label>Password</label>
                    <input type="text" id="user_password" name="user_password" required>
                </div>
            </div>
            <div class="row5">
                <div class="box-input">
                    <label>Role</label>
                    <select type="text" id="role_id" name="role_id" required>
                        <option value="" disabled selected></option>
                        <?php
                        $stmt = $db->prepare("SELECT *  FROM tb_role");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option  value='{$row['role_id']}'>{$row['role_name']}</option>";
                        } ?>
                    </select>
                </div>
                <button type="button" class="save-btn" onclick="btnSaveAddUser()">SAVE</button>
            </div>
        </form>
    </div>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- filter table -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

    <script>
        function btnSaveAddUser() {
            let user_meter_id = $('#user_meter_id').val();
            let user_pea_id = $('#user_pea_id').val();
            let user_first_name = $('#user_first_name').val();
            let user_last_name = $('#user_last_name').val();
            let user_phone = $('#user_phone').val();
            let user_email = $('#user_email').val();
            let user_username = $('#user_username').val();
            let user_password = $('#user_password').val();
            let role_id = $('#role_id').val();

            if (user_meter_id == "" || user_pea_id == "" || user_first_name == "" || user_last_name == "" ||
                user_phone == "" || user_email == "" || user_username == "" || user_password == "" || role_id == "") {
                alert("กรุณากรอกข้อมูลให้ครบถ้วน");
                return;
            }

            let action = "insert_add_user";
            let formData = {
                user_meter_id,
                user_pea_id,
                user_first_name,
                user_last_name,
                user_phone,
                user_email,
                user_username,
                user_password,
                role_id,
                action
            }

            $.ajax({
                url: "../../backend/action.php",
                type: "post",
                data: formData,
                success: function(data) {
                    console.log(data);
                    let add_user = JSON.parse(data);
                    console.log(add_user);

                    if (add_user.code == 200) {
                        alert("บันทึกข้อมูลสำเร็จ");
                        location.reload(true);
                    } else {
                        alert("บันทึกข้อมูลไม่สำเร็จ!!");
                    }
                }
            });

        }
    </script>


    <?php include('./footer.php'); ?>