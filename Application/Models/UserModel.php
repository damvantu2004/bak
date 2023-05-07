<?php

class UserModel extends BaseModel
{
    const TABLE = 'account';

    public function getUserByEmailAndPwd($email, $password)
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE email = '" . $email . "' AND password = '" . md5($password) . "'";
        return $this->getFirstByQuery($sql);
    }

    public function getUserByToken($token)
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE remember_token = '" . $token . "'";
        return $this->getFirstByQuery($sql);
    }


    // todo add function check existence of multiple attributes
    public function isEmailExisted($email)
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE email = '" . $email . "'";
        $rs_sql = $this->getFirstByQuery($sql);
        if ($rs_sql == null || count($rs_sql) == 0) {
            return false;
        }
        return true;
    }

    public function isPhoneExisted($phone)
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE phone = '" . $phone . "'";
        $rs_sql = $this->getFirstByQuery($sql);
        if ($rs_sql == null || count($rs_sql) == 0) {
            return false;
        }
        return true;
    }

    public function getTopCustomers()
    {
        $sql = "SELECT count(`order`.account_id) as orders, sum(order_detail.price) as spendings, RANK() OVER (ORDER BY spendings DESC) rank, account.* from `order`, order_detail, account where order_detail.order_id = `order`.id and `order`.`account_id` = account.id group by account.id limit 5";
        return $this->getByQuery($sql);
    }

    public function getTotalCustomers()
    {
        $sql = "SELECT count(id) as total_customers FROM account where role = 'customer'";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function getAllPaginate()
    {
        $sql = "SELECT * FROM " . self::TABLE . " order by role ASC, created_at DESC";
        // print_r($this->paginate($sql));
        return $this->paginate($sql);
    }

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    public function findUserById($select = ['*'], $id)
    {
        return $this->find(self::TABLE, $select, $id);
    }

    public function createData($data)
    {
        return $this->create(self::TABLE, $data);
    }

    public function deleteData($id)
    {
        $this->delete(self::TABLE, $id);
    }

    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    public function searchAccountFull($accountData)
    {
        $sql = "SELECT *
                FROM account
                where (fname like ('%" . $accountData . "%') 
                        or lname like ('%" . $accountData . "%')
                        or email like ('%" . $accountData . "%')
                        or phone like ('%" . $accountData . "%')
                        or address like ('%" . $accountData . "%')
                        or province like ('%" . $accountData . "%')
                        or role like ('%" . $accountData . "%')) 
                order by id desc";
        return $this->paginate($sql);
    }
}
