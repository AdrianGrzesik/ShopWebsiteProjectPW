<?php
ob_start();
?>
    <div class="product_details">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h3><?php echo $product->name; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="image" style="background-image: url('/uploaded_images/<?php if($product->image!='') { echo $product->image; } else { echo 'no-image-found.jpg';} ?>');"></div>
            </div>
            <div class="col-md-7">
                <div class="add_to_cart">
                    <div class="price">Cena: <span><?php echo $product->price ?> ,-</span></div>
                    <a class="button add_to_cart_button">Dodaj do koszyka</a>
                    <p class="added_info">Produkt został dodany</p>
                    <script>
                        addProductToCart(<?php echo $product->id; ?>);
                    </script>
                </div>
                <div class="description default_font">
                    <?php echo $product->description; ?>
                </div>
            </div>
        </div>
    </div>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame_filters','content', $content);
?>