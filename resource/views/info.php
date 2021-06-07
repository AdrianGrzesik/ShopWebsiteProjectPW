<?php
ob_start();
?>
    <div class="info text-center">
        <div class="default_font">
            <h3><?php echo $info; ?></h3>
            <?php if(isset($button)) echo $button; ?>
        </div>
    </div>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>