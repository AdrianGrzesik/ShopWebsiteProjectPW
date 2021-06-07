<?php
ob_start();
?>
    <div class="default_font">
        <h2><?php echo $news->name; ?></h2>
        <?php echo $news->description; ?>
        <h5>Komentarze</h5>
        <?php if(count($comments)) { ?>
            <ul>
                <?php foreach($comments as $comment) { ?>
                    <li>
                        <h6><?php echo $comment->user_email ?> <span><?php echo date('G:i d-m-Y',strtotime($comment->added_date)) ?></span></h6>
                        <?php echo $comment->comment; ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>Skomentuj jako pierwszy</p>
        <?php } ?>
        <?php if(!users::check()) { ?>
            <p>Aby komentować musisz <a href="/logowanie">się zalogować</a></p>
        <?php } else { ?>
            <form action="" method="post">
                <textarea name="comment_desc"></textarea>
                <?php if(isset($error['comment_desc'])) echo '<p class="err">'.$error['comment_desc'].'</p>'; ?>
                <input type="submit" value="Zapisz" />
            </form>
        <?php } ?>
    </div>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>