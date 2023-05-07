<?php


class CouponModel extends BaseModel
{
    const TABLE = 'coupon';

    public function getCouponDetailById($id)
    {
        $sql = "SELECT *  FROM `coupon` where `id` = '$id'";
        $query = $this->_query($sql);

        return mysqli_fetch_assoc($query);
    }

    public function getAllPaginate()
    {
        $sql = "SELECT * FROM " . self::TABLE . " order by created_at DESC";
        // print_r($this->paginate($sql));
        return $this->paginate($sql);
    }

    public function findCouponById($id)
    {
        $sql = "SELECT * from coupon WHERE id = '$id'";
        $query = $this->_query($sql);

        return mysqli_fetch_assoc($query);
    }

    public function getCouponById($id)
    {
        $sql = "SELECT * from coupon WHERE id = '$id'";
        return $this->getByQuery($sql);
    }

    public function checkIdUnique($id, $idCheck)
    {
        $sql = "select id from " . self::TABLE . " where id = '$id' and id in (SELECT id FROM " . self::TABLE . " WHERE id != '$idCheck')";
        return $this->getByQuery($sql);
    }

    public function createData($data)
    {
        $this->create(self::TABLE, $data);
    }

    public function deleteData($id)
    {
        $sql = "DELETE FROM coupon where  id = '$id'";

        $this->_query($sql);
    }

    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    public function updateDataAfterCheckout($id, $data)
    {
        $status = $data["status"];
        $used_times = $data["used_times"];
        $updated_at = $data["updated_at"];

        $sql = "UPDATE `coupon` SET status=$status, used_times = $used_times, updated_at=$updated_at where id = '$id'";
        $query = $this->_query($sql);
    }

    public function searchCouponFull($couponData)
    {
        $sql = "SELECT coupon.* FROM coupon where(coupon.id like ('%" . $couponData . "%') or coupon.coupon_value like ('%" . $couponData . "%')) or (coupon.used_times like ('%" . $couponData . "%')) order by coupon.created_at desc";
        return $this->paginate($sql);
    }
}
