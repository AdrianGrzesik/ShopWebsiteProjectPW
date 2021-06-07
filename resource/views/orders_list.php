<?php
ob_start();

$status_arr = orders::getStatusArr();
$delivery_types_arr = orders::getDeliveryArr();
?>
    <div class="default_font">
        <h3><?php if(!isset($is_admin)) { ?>Twoje zamówienia<?php } else { ?>Zamówienia<?php } ?></h3>
    </div>
    <table class="orders_list">
        <thead>
            <tr>
                <th>Lp.</th>
                <th>Numer zamówienia</th>
                <th>Data zamówienia</th>
                <th>Do zapłaty</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <?php
        $lp = 0;
        if(count($orders)) {
        ?>
            <?php
            foreach($orders as $order) {
                $lp++;
            ?>
                <tr>
                    <td><?php echo $lp; ?></td>
                    <td><?php echo $order->id; ?></td>
                    <td><?php echo date('G:i d-m-Y',strtotime($order->added_date)); ?></td>
                    <td class="text-right"><?php echo number_format($order->sum,2,'.',' ')?> ,-</td>
                    <td><?php echo $status_arr[$order->status]; ?></td>
                    <td>
                        <?php if(!isset($is_admin)) { ?>
                            <a href="/zamowienie/<?php echo $order->id ?>"><i class="fas fa-search"></i></a>
                        <?php } else { ?>
                            <a href="/admin-zamowienie/<?php echo $order->id ?>"><i class="fas fa-search"></i></a>
                            <a href="/admin-zamowienie/usun/<?php echo $order->id ?>"><i class="fas fa-times"></i></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
    <script>
        $(".orders_list").DataTable();
    </script>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>