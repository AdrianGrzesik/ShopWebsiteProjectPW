function addProductToCart(product_id) {

    let box = $(".add_to_cart");
    let add_button = $(box).find(".add_to_cart_button");
    let added_info = $(box).find(".added_info");

    $(add_button).click(function () {
        $.get('/api/add_products_to_cart/' + product_id, function (return_info) {
            console.log(return_info);
            if (return_info != '') {
                let json = JSON.parse(return_info);
                if (json.products_count != undefined) {
                    $(".cart_assite_products_count").html(json.products_count);
                }
                $(add_button).hide();
                $(added_info).show();
            }
        });
    });

}

function cartProductsList() {

    let obj = this;

    this.box = $(".cart_products_list_box");
    this.empty_info = $(obj.box).find(".empty_info");
    this.products_list = $(obj.box).find(".cart_product_list");
    this.products = [];
    this.cart_sum = $(obj.box).find(".cart_sum");
    this.delivery_types = $(obj.box).find(".delivery_type");
    this.final_sum = $(obj.box).find(".final_sum");

    this.init = function () {

        obj.updateCartSum();

        if ($(obj.products).length > 0) {
            $(obj.products).each(function () {
                let one_product = $(this);
                new oneProductEngine(obj, one_product);
            });
        }


        $(obj.delivery_types).click(function () {
            obj.updateCartSum();
        });
    }

    this.getProducts = function () {
        obj.products = $(obj.box).find(".one_product");
    }

    this.updateCartSum = function () {
        let sum = 0;
        obj.getProducts();
        if ($(obj.products).length > 0) {
            $(obj.products).each(function () {
                let one_product = $(this);
                sum += ($(one_product).find(".price").html() * 1 / 1) * ($(one_product).find(".count").val() * 1 / 1);
            });
        }
        else {
            $(obj.empty_info).show();
            $(obj.products_list).hide();
        }
        $(obj.cart_sum).html(Math.floor(sum * 100) / 100);

        let selected_delivery_type = $(obj.box).find(".delivery_type:checked");
        if (selected_delivery_type.length == 1) {
            sum += $(selected_delivery_type).attr("data-price") * 1 / 1;
        }
        $(obj.final_sum).html(Math.floor(sum * 100) / 100);
    }

    obj.init();
}

function oneProductEngine(cart_list_obj, product) {

    let obj = this;
    this.product = product;
    this.product_id = $(obj.product).attr("data-prodid");
    this.delete_button = $(obj.product).find(".delete");
    this.count_input = $(obj.product).find(".count");
    this.product_sum = $(obj.product).find(".product_sum");
    this.price = $(obj.product).find(".price");

    $(obj.delete_button).click(function () {
        $(obj.product).remove();
        cart_list_obj.updateCartSum();
        $.get('/api/remove_product_from_cart/' + obj.product_id, function (return_info) {
            if (return_info != '') {
                let json = JSON.parse(return_info);
                if (json.products_count != undefined) {
                    $(".cart_assite_products_count").html(json.products_count);
                }
            }
        });
    });

    $(obj.count_input).bind('keyup', function () {
        let val = $(this).val();
        if (!isNaN(val) && val > 0) {
            $(obj.product_sum).html(Math.floor(($(obj.count_input).val() * 1 / 1) * ($(obj.price).html() * 1 / 1) * 100) / 100);
            cart_list_obj.updateCartSum();
            $.get('/api/change_product_count/' + obj.product_id + '/' + $(obj.count_input).val());
        }
    });

}