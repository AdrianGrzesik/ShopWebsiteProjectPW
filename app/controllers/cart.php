<?php

class cart {

    private static $_cart_cache = null;
    private static $_cart_products_cache = null;
    private static $_cookie_key = 'cart_token';

    public function productList() {

        $cart = self::getCart();

        $cart_products = [];
        $cart_products_q = db::query('select cp.id, cp.count, p.name, p.code_name, p.price, p.image, p.id as pid from cart_products as cp inner join products as p on cp.product_id = p.id where p.deleted=0 and cp.cart_id='.$cart->id);
        if(db::num_rows($cart_products_q)) {
            while($rec = db::fetch_assoc($cart_products_q)) {
                $cart_products[] = $rec;
            }
        }

        $first_name = null;
        $last_name = null;
        $address = null;
        $city = null;
        $post_code = null;
        $delivery_type = null;

        $error = [];
        if(users::check()) {
            $user = users::getUser();

            if (request::exist('first_name', 'post')) {
                $first_name = request::get('first_name', 'post');
                if (!$first_name) $error['first_name'] = 'Podaj imię';

                $last_name = request::get('last_name', 'post');
                if (!$last_name) $error['last_name'] = 'Podaj nazwisko';

                $address = request::get('address', 'post');
                if (!$address) $error['address'] = 'Podaj adres';

                $city = request::get('city', 'post');
                if (!$city) $error['city'] = 'Podaj adres';

                $post_code = request::get('post_code', 'post');
                if (!$post_code) $error['post_code'] = 'Podaj adres';

                $delivery_type = request::get('delivery_type', 'post');
                if (!$delivery_type) $error['delivery_type'] = 'Wybierz sposób dostawy';
                if(!isset(orders::getDeliveryArr()[$delivery_type])) $error['delivery_type'] = 'Niepoprawny typ dostawy';

                if (!count($error)) {

                    $cart_products = [];
                    $cart_products_q = db::query('select cp.id, cp.count, p.name, p.code_name, p.price, p.image, p.id as pid from cart_products as cp inner join products as p on cp.product_id = p.id where p.deleted=0 and cp.cart_id='.$cart->id);
                    if(db::num_rows($cart_products_q)) {
                        while($rec = db::fetch_assoc($cart_products_q)) {
                            $cart_products[] = $rec;
                        }
                    }

                    $sum = 0;
                    foreach($cart_products as $product) {
                        $sum += ($product['price']*$product['count']);
                    }
                    $sum += orders::getDeliveryArr()[$delivery_type]['price'];

                    $order = orderModel::create([
                        'cart_id' => $cart->id,
                        'user_id' => $user->id,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'address' => $address,
                        'city' => $city,
                        'post_code' => $post_code,
                        'delivery_type' => $delivery_type,
                        'added_date' => date('Y-m-d G:i:s'),
                        'sum' => $sum,
                        'status' => 1
                    ]);

                    db::query("update cart_products set price=(select price from products where products.id=cart_products.product_id) where cart_id=".$cart->id);
                    self::killCart();

                    redirect('/zamowienie/'.$order->id);

                }

            }
        }

        $view = new views('cart_products_list');
        $view->with('cart_products',$cart_products);
        $view->with('first_name',$first_name);
        $view->with('last_name',$last_name);
        $view->with('address',$address);
        $view->with('city',$city);
        $view->with('post_code',$post_code);
        $view->with('delivery_type',$delivery_type);
        $view->with('error',$error);
        return $view->render();
    }

    static public function getProductsCount() {
        if(!is_array(self::getCartProducts()))
            return 0;
        else
            return count(self::getCartProducts());
    }

    static public function getCart() {
        if(self::$_cart_cache!==null) {
            return self::$_cart_cache;
        }
        else {
            if(isset($_COOKIE[self::$_cookie_key])) {
                self::$_cart_cache = cartModel::where('token','=',db::real_string($_COOKIE[self::$_cookie_key]))->first();
            }
            else {
                $token = randomString(50);
                $val_arr = ['token'=>$token];
                if(users::check()) {
                    $user = users::getUser();
                    $val_arr['user_id'] = $user->id;
                }
                self::$_cart_cache = cartModel::create($val_arr);
                helpersSetCookie(self::$_cookie_key,$token,30);
            }
            return self::$_cart_cache;
        }
    }

    static public function killCart() {
        if(isset($_COOKIE[self::$_cookie_key])) {
            helpersSetCookie(self::$_cookie_key, $_COOKIE[self::$_cookie_key], -1);
            self::$_cart_cache = null;
            self::$_cart_products_cache = null;
        }
    }

    static public function getCartProducts() {
        if(self::$_cart_products_cache!==null) {
            return self::$_cart_products_cache;
        }
        else {
            $cart = self::getCart();
            if($cart) {
                self::$_cart_products_cache = cartProductModel::where('cart_id','=',$cart->id)->get();
            }
            return self::$_cart_products_cache;
        }
    }

    static public function addProduct(int $product_id) {

        $cart = self::getCart();
        if($cart) {
            $cart->addProduct($product_id);
        }

        echo json_encode(['products_count'=>self::getProductsCount()]);

    }

    static public function removeProduct(int $product_id) {

        $cart = self::getCart();
        if($cart) {
            $cart->removeProduct($product_id);
        }

        echo json_encode(['products_count'=>self::getProductsCount()]);

    }

    static public function changeCount(int $product_id, int $count) {

        $cart = self::getCart();
        if($cart) {
            $cart->countProductUpdate($product_id, $count);
        }

    }



}