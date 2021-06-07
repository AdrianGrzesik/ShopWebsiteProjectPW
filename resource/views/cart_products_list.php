<?php
ob_start();
?>
<div class="cart_products_list_box">
    <div class="default_font">
        <h3>Koszyk</h3>
    </div>
    <div class="default_font empty_info" <?php if(count($cart_products)) { ?> style="display:none;" <?php } ?>>
        <p>Brak produktów w koszyku</p>
    </div>
    <?php if(count($cart_products)) { ?>
        <div class="cart_product_list">
            <?php $lp = 0; ?>
            <?php foreach($cart_products as $one_product) { ?>
                <?php $lp++; ?>
                <div class="one_product" data-cartpid="<?php echo $one_product['id']; ?>" data-prodid="<?php echo $one_product['pid']; ?>">
                    <div class="row">
                        <div class="col-md-1">
                            <?php echo $lp; ?>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="image" style="background-image: url('/uploaded_images/<?php if($one_product['image']!='') { echo $one_product['image']; } else { echo 'no-image-found.jpg';} ?>');"></div>
                                </div>
                                <div class="col-md-10">
                                    <h4><?php echo $one_product['name']; ?></h4>
                                    <h5>Cena <span class="price"><?php echo $one_product['price']; ?></span> ,-</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <span class="product_sum"><?php echo $one_product['price']*$one_product['count']; ?></span> ,-
                        </div>
                        <div class="col-md-2">
                            Ilość:
                            <input type="text" class="count" value="<?php echo $one_product['count'] ?>" />
                        </div>
                        <div class="col-md-1">
                            <div class="delete"><i class="fas fa-times"></i></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-3 offset-md-9 text-right">
                    Suma: <span class="cart_sum"></span> ,-
                </div>
            </div>
            <div class="default_font">
                <h3>Finalizuj zamówienie</h3>
            </div>
            <?php if(users::check()) { ?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="default_font">
                            <h5>Dane dostawy</h5>
                        </div>
                        <div>
                            <label for="first_name">Imię</label>
                            <input name="first_name" value="<?php echo $first_name; ?>" />
                            <?php if(isset($error['first_name'])) echo '<p class="err">'.$error['first_name'].'</p>'; ?>
                        </div>
                        <div>
                            <label for="last_name">Nazwisko</label>
                            <input name="last_name" value="<?php echo $last_name; ?>" />
                            <?php if(isset($error['last_name'])) echo '<p class="err">'.$error['last_name'].'</p>'; ?>
                        </div>
                        <div>
                            <label for="address">Ulica, nr domu / nr lokalu</label>
                            <input name="address" value="<?php echo $address; ?>" />
                            <?php if(isset($error['address'])) echo '<p class="err">'.$error['address'].'</p>'; ?>
                        </div>
                        <div>
                            <label for="city">Miejscowość</label>
                            <input name="city" value="<?php echo $city; ?>" />
                            <?php if(isset($error['city'])) echo '<p class="err">'.$error['city'].'</p>'; ?>
                        </div>
                        <div>
                            <label for="post_code">Kod pocztowy</label>
                            <input name="post_code" value="<?php echo $post_code; ?>" />
                            <?php if(isset($error['post_code'])) echo '<p class="err">'.$error['post_code'].'</p>'; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="default_font">
                            <h5>Sposób dostawy</h5>
                            <div>
                                <?php
                                $delivery_arr = orders::getDeliveryArr();
                                if(count($delivery_arr)) {
                                    foreach($delivery_arr as $d_id => $delivery) {
                                        ?>
                                        <p><input class="delivery_type" name="delivery_type" type="radio" value="<?php echo $d_id; ?>" data-price="<?php echo $delivery['price']; ?>" <?php if($delivery_type==1) echo 'checked'; ?> /> <?php echo $delivery['name']; ?> (<?php echo $delivery['price']; ?> ,-)</p>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php if(isset($error['delivery_type'])) echo '<p class="err">'.$error['delivery_type'].'</p>'; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-md-9 text-right">
                        Do zapłaty: <span class="final_sum"></span> ,-
                    </div>
                </div>
                <div class="text-right">
                    <input class="button" type="submit" value="Potwierdzam zamówienie" />
                </div>
            </form>
            <?php } else { ?>
                <p>Aby złożyć zamówienie <a href="/logowanie">zaloguj się</a> lub <a href="/rejestracja">załóż konto</a></p>
            <?php } ?>
        </div>
        <script>
            new cartProductsList();
        </script>
    <?php } ?>
</div>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>