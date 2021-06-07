<?php

class orders {

    static public function ordersList() {
        users::redirectIfNotLogin();

        $user = users::getUser();
        $orders = orderModel::where('user_id','=',$user->id)->get();

        $view = new views('orders_list');
        $view->with('orders',$orders);
        return $view->render();
    }

    static public function ordersDetails($order_id) {
        users::redirectIfNotLogin();

        $user = users::getUser();
        $order = orderModel::where('user_id','=',$user->id)->find($order_id);

        if($order) {
            $cart = cartModel::find($order->cart_id);
            $cart_products = [];
            $cart_products_q = db::query('select cp.id, cp.count, p.name, p.code_name, p.price, p.image, p.id as pid from cart_products as cp inner join products as p on cp.product_id = p.id where p.deleted=0 and cp.cart_id='.$cart->id);
            if(db::num_rows($cart_products_q)) {
                while($rec = db::fetch_assoc($cart_products_q)) {
                    $cart_products[] = $rec;
                }
            }

            $status_name = self::getStatusArr()[$order->status];
            $delivery_type = self::getDeliveryArr()[$order->delivery_type];

            $view = new views('order_details');
            $view->with('order',$order);
            $view->with('cart',$cart);
            $view->with('cart_products',$cart_products);
            $view->with('status_name',$status_name);
            $view->with('delivery_type',$delivery_type);
            return $view->render();
        }
        else {
            redirect('/');
        }
    }

    

    static public function getDeliveryArr() {
        return  [
            1=>['name'=>'Kurier','price'=>16],
            2=>['name'=>'Poczta polska','price'=>10],
            3=>['name'=>'Odbiór osobisty','price'=>0],
        ];
    }

    static public function getStatusArr() {
        return [
            1=>'Do zapłaty',
            10=>'Anulowane',
            20=>'Zapłacone',
            30=>'Zrealizowane'
        ];
    }

}