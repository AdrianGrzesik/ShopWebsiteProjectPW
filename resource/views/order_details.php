<?php
ob_start();
?>
    <?php if(!$order) { ?>
    <div class="default_font">
        <h4>Nie znaleziono zamówienia</h4>
    </div>
    <?php } else { ?>
    <div class="default_font">
        <h3>Szczegóły zamówienia nr: <?php echo $order->id; ?></h3>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="default_font">
                <h5>Dane dostawy</h5>
                <p>
                    <?php echo $order->first_name.' '.$order->last_name; ?><br />
                    <?php echo $order->address; ?><br />
                    <?php echo $order->city.' '.$order->post_code; ?><br />
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="default_font">
                <h5>Status</h5>
                <?php if(!isset($is_admin)) { ?>
                <p><?php echo $status_name; ?></p>
                <?php } else { ?>
                    <form action="" method="post">
                    <select name="status">
                        <?php foreach($status_arr as $s_key => $s_name) { ?>
                            <option value="<?php echo $s_key; ?>" <?php if($order->status==$s_key){ ?> selected <?php } ?>><?php echo $s_name; ?></option>
                        <?php } ?>
                    </select>
                        <input type="submit" value="Zapisz" />
                        <?php echo $status_info; ?>
                    </form>
                <?php } ?>
                <h6>Metoda dostawy</h6>
                <p><?php echo $delivery_type['name']; ?> (<?php echo $delivery_type['price'] ?> ,-)</p>
                <?php if($order->status==1&&!isset($is_admin)) { ?>
                  <h6>Dane do płatności</h6>
                    <p>Jakieś fajne dane Sp. z o.o.<br />
                        Ul. Marzałkowska 999<br />
                        Warszawa 12-321</p>
                    <p>Nr konta: 1001 1001 1001 1001 1001 1001</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="default_font cart_products_list_box">
                <h5>Produkty</h5>
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
                                <div class="col-md-2 text-right">
                                    <?php echo number_format($one_product['price']*$one_product['count'],2,'.',' '); ?> ,-
                                </div>
                                <div class="col-md-2">
                                    Ilość: <?php echo $one_product['count'] ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-12 default_font text-right">
            <h4>Suma</h4>
            <p><?php echo number_format($order->sum,2,'.',' '); ?> ,-</p>
        </div>
    </div>
    <?php } ?>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>