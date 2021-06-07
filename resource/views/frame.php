<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Sklep Studia PW OKNO</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/css/main.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="/js/main.js"></script>
</head>
<body>
    <div class="container page">
        <div class="row">
            <div class="col-md-12">
                <div class="page_top">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="logo">
                                <a href="/"><img src="/img/logo.png" alt="" title="" /></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="menu">
                                <ul>
                                    <li><a href="/produkty">Produkty</a></li>
                                    <li><a href="/artykuly">Artykuły</a></li>
                                    <li><a href="/kontakt">Kontakt</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="user_asside">
                                <?php if(!users::check()) { ?>
                                    <a href="/logowanie">Zaloguj się / zarejestruj</a>
                                <?php } else {
                                    $user = users::getUser();
                                    ?>
                                    <p><?php echo $user->email; ?> <a href="/zamowienia">Zamówienia</a> <a href="/wyloguj">Wyloguj</a></p>
                                <?php } ?>
                            </div>
                            <div class="cart_asside">
                                <a href="/koszyk"><i class="fas fa-shopping-cart"></i> (<span class="cart_assite_products_count"><?php echo cart::getProductsCount(); ?></span>)</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(users::isAdmin()) { ?>
                    <div class="menu_admin">
                        <div class="row">
                            <div class="col-md-2 title text-right">
                                Menu admina
                            </div>
                            <div class="col-md-10 menu">
                                <ul>
                                    <li><a href="/admin-produkty">Produkty</a></li>
                                    <li><a href="/admin-artykuly">Artykuły</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="page_content">
                    {{{content}}}
                </div>
                <div class="page_footer">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="logo">
                                <a href="/"><img src="/img/logo.png" alt="" title="" /></a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="company_data">
                                Projekt Zespołowy  Sp. z o.o.<br />
                                Ul. Marzałkowska 999<br />
                                Warszawa 12-321
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>