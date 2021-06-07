<?php
ob_start();
?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="" method="post">
                <div class="default_font">
                    <h4 class="text-center">Zaloguj się</h4>
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="email" />
                            <?php if(isset($error['email'])) echo '<p class="err">'.$error['email'].'</p>'; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label for="password">Hasło</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" name="password" />
                            <?php if(isset($error['password'])) echo '<p class="err">'.$error['password'].'</p>'; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 offset-md-4">
                            <input type="submit" value="Zaloguj" />
                            <p><a href="/rejestracja">Zarejestruj się</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>