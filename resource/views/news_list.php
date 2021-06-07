<?php
ob_start();
?>
    <div class="news_list">
        <div class="row">
            <div class="col-md-12 little-title">
                <h4>Artykuły</h4>
            </div>
        </div>
        <?php if(!count($news)) { ?>
            <div class="default_font">
                <h4>Nie znaleziono artykułów</h4>
            </div>
        <?php } else { ?>
            <div class="row">
            <?php $lp = 0; ?>
            <?php foreach($news as $one_news) { ?>
                <?php $lp++; ?>
                <div class="col-md-3 one_news">
                    <a href="/artykul/<?php echo $one_news->code_name; ?>">
                        <h4><?php echo $one_news->name; ?></h4>
                    </a>
                </div>
                <?php if($lp%4==0) { ?></div><div class="row"><?php } ?>
            <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php if($pages_count>0) { ?>
    <div class="paggination">
        <ul>
            <?php for($i = 1; $i<=$pages_count; $i++) { ?>
                <li><a href="/artykuly/<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>