<?php

class CartHelper // dung de tach phan add ben controller sang helper
{


    public $items = [];
    public $total_quantity = 0;
    public $total_price = 0;
    public $discount = 0;

    public function __construct()
    {
        // giup khi an add moi thi items van con item chu khong khoi tao items lai tu dau
        $this->items = empty($_SESSION['cart'])  ? [] : $_SESSION['cart'];
        $this->get_total_quantity();
        $this->total_price = $this->get_total_price();
    }

    public function add($product, $quantity = 1)
    {
        if (isset($this->items[$product['id']])) {
            $this->items[$product['id']]['quantity'] += $quantity; // them 1 san pham vao so luong san co trong cart
            $this->items[$product['id']]['price_sum'] = $this->items[$product['id']]['price'] * $this->items[$product['id']]['quantity'];
        } else {
            // them 1 san pham neu chua co sp nao trong cart
            $item = [
                'id' => $product['id'],
                'name' => $product['name'],
                'image' => $product['image'],
                'quantity' => $quantity,
                'price' => $product['sale_price'] >  0 ? $product['sale_price'] : $product['price'], // de y sale_price check neu co sale price set price = sale price
                'price_sum' => ($product['sale_price'] >  0 ? $product['sale_price'] : $product['price']) * $quantity
            ];
            $this->items[$product['id']] = $item;  // product id lam key

        }
        $_SESSION['cart'] = $this->items; // luu session key cart luu toan bo item, de khi add item khac thi item add trc do van con trong cart
        $this->get_total_quantity();
        $this->total_price = $this->get_total_price();
    }

    public function delete($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
            $_SESSION['cart'] = $this->items;
            $this->get_total_quantity();
            $this->total_price = $this->get_total_price();
        }
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
        $_SESSION['total_quantity'] = 0;
    }

    public function update($id, $quantity)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
            $this->items[$id]['price_sum'] = $this->items[$id]['price'] * $this->items[$id]['quantity'];
            $_SESSION['cart'] = $this->items;
            $this->get_total_quantity();
        }
    }


    private function get_total_quantity()
    {
        $total_quantity = 0;
        foreach ($this->items as $item) {
            $total_quantity += $item['quantity'];
        }
        $this->total_quantity = $total_quantity;
        $_SESSION['total_quantity'] = $this->total_quantity;
        // return $this->total_quantity;
    }

    public function get_total_price()
    {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item['quantity'] * $item['price'];
        }
        return $price;
    }
}