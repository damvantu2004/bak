<?php

class ReviewModel extends BaseModel
{
    const TABLE = 'review';

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    public function getAvgRatingAll()
    {
        $sql = "SELECT round(AVG(rating),1) as avg_rating FROM `review`";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function getAvgRating($id)
    {
        $sql = "SELECT  round(AVG(rating),1) as rating from review where review.product_id = $id";
        return $this->getFirstByQuery($sql);
    }

    public function getAllReviewByProductId($id)
    {
        // { DB::table('review')->join('account', 'review.account_id', '=', 'account.id')->select('review.*', 'account.fname', 'account.lname')->where('review.product_id', '=', $id)->orderBy('review.created_at', 'DESC')->get();
        $sql = "SELECT review.*, account.fname, account.lname from review, account where review.account_id = account.id and review.product_id = $id order by review.created_at DESC";
        return $this->getByQuery($sql);
    }

    public function getAllReviewByProductIdPaginate($id)
    {
        // { DB::table('review')->join('account', 'review.account_id', '=', 'account.id')->select('review.*', 'account.fname', 'account.lname')->where('review.product_id', '=', $id)->orderBy('review.created_at', 'DESC')->get();
        $sql = "SELECT review.*, account.fname, account.lname, account.email from review, account where review.account_id = account.id and review.product_id = $id order by review.created_at DESC";
        return $this->paginate($sql);
    }

    public function getReviewList()
    {
        $sql = "SELECT product.id, product.image, product.name ,round(avg(review.rating),1) as average_rating, count(review.id) as total_review FROM review INNER join product on review.product_id = product.id GROUP by product.id";
        return $this->paginate($sql);
    }
    public function findReviewById($select = ['*'], $id)
    {
        return $this->find(self::TABLE, $select, $id);
    }

    public function deleteData($id)
    {
        $this->delete(self::TABLE, $id);
    }

    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    public function createData($data)
    {
        $this->create(self::TABLE, $data);
    }

    public function searchReviewListFull($reviewData)
    {
        $sql = "SELECT product.id, product.image, product.name ,round(avg(review.rating),1) as average_rating, count(review.id) as total_review FROM review INNER join product on review.product_id = product.id 
                where (product.name like ('%" . $reviewData . "%')) 
                GROUP by product.id  order by id desc";
        return $this->paginate($sql);
    }

    public function searchReviewFullForProduct($id, $reviewData)
    {
        $sql = "SELECT review.*, account.fname, account.lname, account.email from review, account
                where  review.account_id = account.id and review.product_id = $id and (account.fname like ('%" . $reviewData . "%') or account.lname like ('%" . $reviewData . "%') or
                account.email like ('%" . $reviewData . "%') or content like ('%" . $reviewData . "%')) 
                order by review.id desc";
        return $this->paginate($sql);
    }
}
