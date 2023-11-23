<section class="itq-wrapper">
    <form action="" method="post">
      <fieldset>
        <legend>Quên thông tin tài khoản:</legend>
        <?php if($error = $this->session->flashdata('email_not_exist')) :?>
            <p style="font-size: 13px;color: red;margin-left: 5px;;"> <?=$error ?></p>
        <?php endif; ?>
        <?php echo common_showerror(validation_errors());?>
        <label><p>Email:</p><input type="text" class="txtEmail" value="<?= common_valuepost(isset($email)?$email:'');?>" name="email"></label>
        <section><input type="submit" name="forgot" value="Gửi mã xác nhận" class="btnForgot"><input type="reset" value="Làm lại" class=""></section>
        <nav>
            <ul>
                <li><a href="<?= base_url()?>" title="Về trang chủ">Về trang chủ</a></li>
                <li>/</li>
                <li><a href="<?= base_url('auth/auth/login')?>" title="Đăng nhập">Đăng nhập</a></li>
            </ul>      
        </nav>
    </fieldset>
    </form>
</section>
