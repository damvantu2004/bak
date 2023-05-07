<?php

class ProductModel extends BaseModel
{
    const TABLE = 'product';

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    public function findProductById($select = ['*'], $id)
    {
        return $this->find(self::TABLE, $select, $id);
    }

    public function checkNameUnique($name, $nameCheck)
    {
        // {select name from product where name = 'rye flour' and name in (SELECT name FROM `product` WHERE name != 'blueberry cake')
        $sql = "select name from " . self::TABLE . " where name = '$name' and name in (SELECT name FROM " . self::TABLE . " WHERE name != '$nameCheck')";
        return $this->getByQuery($sql);
    }

    public function findProductByName($name)
    {
        $sql = "SELECT * from product WHERE name = '$name'";
        return $this->getByQuery($sql);
    }

    public function createData($data)
    {
        $this->create(self::TABLE, $data);
    }

    public function deleteData($id)
    {
        $this->delete(self::TABLE, $id);
    }

    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    public function getByCategoryId($categoryId, $productId = null)
    { //lấy dánh sách 
        $sql = "SELECT * FROM " . self::TABLE . " WHERE category_id = ${categoryId} order by id DESC";
        if ($productId) {
            $sql = "SELECT * FROM " . self::TABLE . " WHERE category_id = ${categoryId} and id !=${productId}";
        }

        return $this->getByQuery($sql);
    }
    public function getByCategoryIdPaginate($categoryId)
    { //lấy dánh sách 
        $sql = "SELECT * FROM " . self::TABLE . " WHERE category_id = ${categoryId} and status = 1 order by id DESC";

        return $this->paginate($sql);
    }

    public function getAllPaginate()
    {
        $sql = "SELECT * FROM " . self::TABLE . " where status = 1 order by id DESC";
        // print_r($this->paginate($sql));
        return $this->paginate($sql);
    }

    public function searchProduct($productName)
    {
        $sql = "SELECT product.*, category.name as category_name FROM product JOIN category ON
        product.category_id = category.id";
        $whereName = ' product.name like "%' . $productName . '%" having product.status = 1';
        $sql .= " WHERE ${whereName}";
        return $this->paginate($sql);
    }

    public function searchProductFull($productData)
    {
        $sql = "SELECT product.*, category.name as category_name FROM product JOIN category ON product.category_id = category.id where(product.name like ('%" . $productData . "%') or product.price like ('%" . $productData . "%')) or (category.name like ('%" . $productData . "%')) having product.status = 1 order by product.id desc";
        return $this->paginate($sql);
    }

    public function getTotalProducts()
    {
        $sql = "SELECT count(id) as total_products FROM product";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }


    public function getTopProducts()
    {
        $sql = "SELECT sum(order_detail.quantity) as purchased, RANK() OVER (ORDER BY purchased DESC) rank,  product.* , category.name as category_name from order_detail, product, category where product.id = order_detail.product_id and product.category_id = category.id GROUP BY product.id LIMIT 5";
        return $this->getByQuery($sql);
    }

    public function countOrders($id)
    {
        $sql = "SELECT count(order_id) as count FROM order_detail WHERE product_id = $id";
        return $this->getByQuery($sql);
    }

    public function getProductHighestSalePercent()
    {
        $sql = "SELECT *, round((1-sale_price/price)*100, 1 ) as percent FROM `product` where sale_price != 0 order by percent DESC LIMIT 1";
        $query = $this->_query($sql);

        return mysqli_fetch_assoc($query);
    }

    public function getProducts($limit = 100)
    {
        $sql = "SELECT product.* FROM product where status = 1
            ORDER BY id  DESC LIMIT ${limit}";

        return $this->getByQuery($sql);
    }

    public function getProductById($productId)
    {
        $sql = "SELECT product.*, category.name as category_name FROM product JOIN category ON
         product.category_id = category.id WHERE product.id = ${productId}";

        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function getListProductPaginate()
    {
        $sql = "SELECT product.*, category.name as category_name FROM product
            JOIN category ON product.category_id = category.id order by id DESC";

        return $this->paginate($sql);
    }

    public function deleteProductByIdCategory($id)
    {
        $sql = "DELETE FROM product WHERE category_id = ${id} ";
        $this->_query($sql);
    }

    public function deleteProductByIdUser($id)
    {
        $sql = "DELETE FROM product WHERE user_id = ${id} ";
        $this->_query($sql);
    }
}
