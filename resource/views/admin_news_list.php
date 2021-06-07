<?php
ob_start();
?>
    <div class="default_font">
        <h3>Lista artykułów <a class="button" href="/admin-artykuly/dodaj">Dodaj artykuł</a></h3>
    </div>
    <table class="admin-news-list">
        <thead>
        <tr>
            <th>Lp.</th>
            <th>Nazwa</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($news)) { ?>
            <?php $lp = 0; ?>
            <?php foreach($news as $one_news) { ?>
                <?php $lp++; ?>
                <tr>
                    <td><?php echo $lp; ?></td>
                    <td><?php echo $one_news->name ?></td>
                    <td>
                        <div class="text-right">
                            <a href="/admin-artykuly/edytuj/<?php echo $one_news->id; ?>" title="Edytuj"><i class="far fa-edit"></i></a>
                            <a href="/admin-artykuly/usun/<?php echo $one_news->id; ?>" title="Usuń"><i class="fas fa-times"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
    <script>
        $(".admin-news-list").DataTable();
    </script>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>