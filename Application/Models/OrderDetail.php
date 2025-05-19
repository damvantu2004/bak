<?php


class OrderDetail extends BaseModel
{
    const TABLE = "order_detail";

    public function store($data)
    { 
        // Thay vì gọi create() của BaseModel, ta sẽ trực tiếp chèn dữ liệu
        $colums = implode(',', array_keys($data));
        
        $newValues = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data));
        
        $values = implode(',', $newValues);
        
        $sql = "INSERT INTO `" . self::TABLE . "` (${colums}) VALUE (${values})";
        
        // Thực thi câu lệnh SQL và không cần trả về bản ghi nào
        $this->_query($sql);
    }

}
