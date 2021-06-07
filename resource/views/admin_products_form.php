<?php
ob_start();
?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        <div class="default_font">
                            <h3>Dodaj produkt</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <label for="email">Nazwa</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" value="<?php echo $name; ?>" />
                        <?php if(isset($error['name'])) echo '<p class="err">'.$error['name'].'</p>'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <label for="email">Cena</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="price" value="<?php echo $price; ?>" />
                        <?php if(isset($error['price'])) echo '<p class="err">'.$error['price'].'</p>'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <label for="email">Opis</label>
                    </div>
                    <div class="col-md-8">
                        <textarea name="description"><?php echo $description; ?></textarea>
                        <?php if(isset($error['description'])) echo '<p class="err">'.$error['description'].'</p>'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <label for="email">Zdjęcie</label>
                    </div>
                    <div class="col-md-8">
                        <?php if($image!='') { ?>
                            <img style="width:200px;" src="/uploaded_images/<?php echo $image; ?>" alt="" title="" />
                        <?php } ?>
                        <input type="file" name="image" />
                        <?php if(isset($error['image'])) echo '<p class="err">'.$error['image'].'</p>'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        <input type="submit" value="Zapisz" />
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