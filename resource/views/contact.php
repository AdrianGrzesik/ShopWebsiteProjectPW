<?php
ob_start();
?>
<div class="contact">
    <h3>Studia OKNO</h3>
    <img src="/img/logo.png" alt="" title="" />
    <p>Projekty sklepu wykonany<br />jako zaliczenie przedmiotu<br />Projekt Zespołowy<br />Politechnika Warszawska<br /><strong>OKNO</strong></p>
    <p>Autorzy projektu<br /><strong>Bartosz Pióro 302081</strong> <br/><strong>Adrian Grzesik 301036</strong></p>
</div>
<?php
$content = ob_get_contents();
ob_clean();
echo views::include_to_view('frame','content', $content);
?>