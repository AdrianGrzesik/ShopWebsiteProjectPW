<?php

class products {

    public function productsList($active_page = null) {

        if(!$active_page)
            $active_page = 1;
        //for future filters
        $search_name = '';
        $prod_q = productModel::where('deleted','=',0);
        if($search_name)
            $prod_q->where('name','like','%'.$search_name.'%');
        //counting pages
        $products_count = $prod_q->count();
        $per_page = 9;

        $pages_count = floor($products_count/$per_page);
        if($products_count%$per_page!=0)
            $pages_count++;
        //current page
        $offset = $active_page*$per_page-$per_page;
        //products to show
        $products = $prod_q->limit($offset, $per_page)->get();
        //the view
        $view = new views('products_list');
        $view->with('products',$products);
        $view->with('pages_count',$pages_count);
        return $view->render();
    }

    public function productDetails($name) {

        $product = productModel::where('code_name','=',$name)->where('deleted','=',0)->first();
        if($product) {
            $view = new views('products_details');
            $view->with('product',$product);
            return $view->render();
        }
        else {
            $view = new views('404');
            return $view->render();
        }
    }

    public function adminList() {
        $products = productModel::where('deleted','=',0)->get();

        $view = new views('admin_products_list');
        $view->with('products',$products);
        return $view->render();
    }

    public function adminForm($prod_id = null) {

        $error = [];

        if(!$prod_id) {
            $name = '';
            $price = '';
            $description = '';
            $image = '';
        }
        else {
            $product = productModel::where('deleted','=',0)->find($prod_id);
            if($product) {
                $name = $product->name;
                $price = $product->price;
                $description = $product->description;
                $image = $product->image;
            }
            else
                redirect('/admin-produkty');
        }

        if(request::exist('name','post')) {

            $name = request::get('name','post');
            if($name=='')
                $error['name'] = 'Podaj nazwę produktu';

            $price = request::get('price','post');
            if($price=='')
                $error['price'] = 'Podaj cenę produktu';
            elseif(!is_numeric($price))
                $error['price'] = 'Podana cena nie jest liczbą';

            $description = request::get('description','post');
            if($description=='')
                $error['description'] = 'Podaj opis produktu';

            if(isset($_FILES['image'])&&$_FILES['image']['name']!='') {
                $file = $_FILES['image'];
                $file_type = @end(@explode('.',$file['name']));
                $file_size = $file['size'];

                if(!in_array(strtolower($file_type),['jpg','jpeg','png']))
                    $error['image'] = 'Niepoprawne rozszeżenie pliku, dopuszczalne: jpg, png';
                elseif($file_size>5000000)
                    $error['image'] = 'Plik jest za duży, dopuszczalny rozmiar: 5MB';

                if(!count($error)) {
                    $image = time().'_'.$file['name'];
                    move_uploaded_file($file['tmp_name'],public_path().'/uploaded_images/'.$image);
                }
            }

            if(count($error)==0) {
                if(!$prod_id) {
                    productModel::create([
                        'name' => $name,
                        'code_name' => codeLinkSpecialChars($name),
                        'price' => $price,
                        'description' => $description,
                        'image' => $image,
                    ]);
                }
                else {
                    $product->name = $name;
                    $product->code_name = codeLinkSpecialChars($name);
                    $product->price = $price;
                    $product->description = $description;
                    $product->image = $image;
                    $product->save();
                }

                redirect('/admin-produkty');
            }
        }

        $view = new views('admin_products_form');
        $view->with('name',$name);
        $view->with('price',$price);
        $view->with('description',$description);
        $view->with('image',$image);
        $view->with('error',$error);
        return $view->render();
    }

    public function adminDelete($prod_id) {
        $product = productModel::where('deleted','=',0)->find($prod_id);
        if($product) {
            $product->deleted = 1;
            $product->save();
        }

        redirect('/admin-produkty');
    }

}