<section class="itq-wrapper">
    <form action="<?= base_url('auth/auth/change_Password')?>" method="post">
      <fieldset>
        <legend>Reset thông tin tài khoản:</legend>
        <?php echo common_showerror(validation_errors());?>
        <?php if($error = $this->session->flashdata('username_not_exist')) :?>
            <p style="font-size: 13px;color: red;margin-left: 5px;;"> <?=$error ?></p>
        <?php endif; ?>
        <label><p>Tên người dùng:</p><input type="text" class="txtUsername" value="<?= common_valuepost(isset($username)?$username:'');?>" name="username"></label>
        <label><p>Mật khẩu mới:</p><input type="password" class="txtPassword" value="<?= common_valuepost(isset($password)?$password:'');?>" name="password"></label>
        <label><p>Xác nhận mật khẩu:</p><input type="password" class="txtPassword" value="<?= common_valuepost(isset($password_again)?$password_again:'');?>" name="password_again"></label>      
        <section><input type="submit" name="change" value="Cập nhật" class="btnChange="></section>       
        <nav>
            <ul>
                <li><a href="<?= base_url('auth/auth/login')?>">Login</a></li>               
            </ul>      
        </nav>
      </fieldset>
    </form>
</section>
