<section class="itq-wrapper">
    <form action="<?= base_url('auth/auth/login')?>" method="post">
      <fieldset>
        <legend>Đăng nhập vào hệ thống:</legend>
        
        <?php echo common_showerror(validation_errors());?>
        <?php if($error = $this->session->flashdata('username_not_exist')) :?>
            <p style="font-size: 13px;color: red;margin-left: 5px;;"> <?=$error ?></p>
        <?php endif; ?>
        <?php if($error = $this->session->flashdata('password_not_exist')) :?>
            <p style="font-size: 13px;color: red;margin-left: 5px;;"> <?=$error ?></p>
        <?php endif; ?>
        <label><p>Tên sử dụng:</p><input type="text" class="txtUsername" value="<?= common_valuepost(isset($username)?$username:'');?>" name="username"></label>
        <label><p>Mật khẩu:</p><input type="password" class="txtPassword" value="<?= common_valuepost(isset($password)?$password:'');?>" name="password"></label>
        <section><input type="submit" name="login" value="Đăng nhập" class="btnLogin"><input type="reset" value="Làm lại" class=""></section>
        <nav>
            <ul>
                <li><a href="<?= base_url()?>">Về trang chủ</a></li>
                <li>/</li>
                <li><a href="<?= base_url('auth/auth/forgot')?>">Quên mật khẩu</a></li>
            </ul>      
        </nav>
    </fieldset>
    </form>
</section>
