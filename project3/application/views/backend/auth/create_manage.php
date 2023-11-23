<section class="itq-wrapper">
    <form action="<?= base_url('auth/auth/create_manage')?>" method="post">
      <fieldset>
        <legend>Tạo tài khoản quản trị:</legend>
        
        <?php echo common_showerror(validation_errors());?>
        <label><p>Tên sử dụng:</p><input type="text" class="txtUsername" value="<?= common_valuepost(isset($username)?$username:'');?>" name="username"></label>
        <label><p>Mật khẩu:</p><input type="password" class="txtPassword" value="<?= common_valuepost(isset($password)?$password:'');?>" name="password"></label>
        <label><p>Email:</p><input type="text" class="txtEmail" value="<?= common_valuepost(isset($email)?$email:'');?>" name="email"></label>
        <section><input type="submit" name="create" value="Tạo mới" class="btnCreate"><input type="reset" value="Làm lại" class=""></section>
        <nav>
            <ul>
                <li><a href="<?= base_url()?>">Về trang chủ</a></li>          
            </ul>      
        </nav>
    </fieldset>
    </form>
</section>
