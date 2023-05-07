<?php

class ContactModel extends BaseModel
{
    const TABLE = 'contact';

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    public function getAllPaginate()
    {
        $sql = "SELECT * FROM " . self::TABLE . " order by id DESC";
        // print_r($this->paginate($sql));
        return $this->paginate($sql);
    }

    public function findContactById($select = ['*'], $id)
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

    public function searchContactFull($contactData)
    {
        $sql = "SELECT * from contact
                where (contact.name like ('%" . $contactData . "%') or email like ('%" . $contactData . "%')
                        or phone like ('%" . $contactData . "%') or message like ('%" . $contactData . "%')) 
             order by id desc";
        return $this->paginate($sql);
    }
}
