<?php


class OrderDetail extends BaseModel
{
    const TABLE = "order_detail";

    public function store($data)
    { //luu thong tin vao ban detail
        $this->create(self::TABLE, $data);
    }

}
