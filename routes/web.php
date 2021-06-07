<?php

route::add('/','products@productsList');
route::add('/produkty','products@productsList');
route::add('/produkty/{active_page}','products@productsList');
route::add('/produkt/{name}','products@productDetails');
route::add('/artykuly','news@newsList');
route::add('/artykuly/{active_page}','news@newsList');
route::add('/artykul/{name}','news@newsDetails');

route::add('/kontakt','home@contactPage');
route::add('/koszyk','cart@productList');

route::add('/logowanie','users@loginForm');
route::add('/rejestracja','users@registerForm');
route::add('/wyloguj','users@logout');

route::add('/admin-produkty','products@adminList');
route::add('/admin-produkty/dodaj','products@adminForm');
route::add('/admin-produkty/edytuj/{id}','products@adminForm');
route::add('/admin-produkty/usun/{id}','products@adminDelete');

route::add('/admin-artykuly','news@adminList');
route::add('/admin-artykuly/dodaj','news@adminForm');
route::add('/admin-artykuly/edytuj/{id}','news@adminForm');
route::add('/admin-artykuly/usun/{id}','news@adminDelete');

route::add('/api/add_products_to_cart/{product_id}','cart@addProduct');
route::add('/api/remove_product_from_cart/{product_id}','cart@removeProduct');
route::add('/api/change_product_count/{product_id}/{count}','cart@changeCount');

route::add('/zamowienia','orders@ordersList');
route::add('/zamowienie/{order_id}','orders@ordersDetails');