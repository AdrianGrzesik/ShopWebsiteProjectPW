<?php
ob_start();
?>
    <div class="default_font">
        <h3>Lista produktów <a class="button" href="/admin-produkty/dodaj">Dodaj produkt</a></h3>
    </div>
    <table class="admin-products-list">
        <thead>
        <tr>
            <th>Lp.</th>
            <th>Zdjęcie</th>
            <th>Nazwa</th>
            <th>Cena</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($products)) { ?>
            <?php $lp = 0; ?>
            <?php foreach($products as $product) { ?>
                <?php $lp++; ?>
                <tr>
                    <td><?php echo $lp; ?></td>
                    <td><?php if($product->image!='') { ?><img style="width:100px" src="/uploaded_images/<?php echo $product->image; ?>" alt="" title="" /><?php } ?></td>
                    <td><?php echo $product->name ?></td>
                    <td><?php echo $product->price ?></td>
                    <td>
                        <div class="text-right">
                            <a href="/admin-produkty/edytuj/<?php echo $product->id; ?>" title="Edytuj"><i class="far fa-edit"></i></a>
                            <a href="/admin-produkty/usun/<?php echo $product->id; ?>" title="Usuń"><i class="fas fa-times"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
    <script>
        $(".admin-products-list").DataTable();
    </script>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>