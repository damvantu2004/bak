<?php

class UserModel extends BaseModel
{
    const TABLE = 'account';

    public function getUserByEmailAndPwd($email, $password)
    {
        // Đầu tiên, lấy thông tin người dùng dựa trên email
        $sql = "SELECT * FROM " . self::TABLE . " WHERE email = '" . $email . "'";
        $user = $this->getFirstByQuery($sql);
        
        if (!$user) {
            return null; // Không tìm thấy email
        }
        
        // Kiểm tra xem mật khẩu được mã hóa bằng bcrypt hay md5
        if (password_verify($password, $user['password'])) {
            return $user; // Mật khẩu bcrypt đúng
        } elseif ($user['password'] === md5($password)) {
            return $user; // Mật khẩu md5 đúng (cho các tài khoản cũ)
        }
        
        return null; // Mật khẩu không đúng
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
        $sql = "SELECT * FROM " . self::TABLE . " order by updated_at DESC";
        // print_r($this->paginate($sql));
        return $this->paginate($sql);
    }

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    public function findUserById($select, $id)
    {
        $column = implode(',', $select);
        $sql = "SELECT $column FROM account WHERE id = $id";
        $query = $this->_query($sql);

        return mysqli_fetch_assoc($query);
    }

    public function findUserByEmail($select, $email)
    {
        $column = implode(',', $select);
        $sql = "SELECT $column FROM account WHERE email = '$email'";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function checkEmailUnique($email, $idCheck)
    {
        $sql = "select email from " . self::TABLE . " where email = '$email' and id not in (SELECT id FROM " . self::TABLE . " WHERE id = $idCheck)";
        return $this->getByQuery($sql);
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

    public function updateUserStatus($id, $status)
    {
        $data = [
            'status' => $status,
            'updated_at' => date("Y-m-d", time())
        ];
        $this->update(self::TABLE, $id, $data);
    }

    public function searchUserFull($userData)
    {
        $sql = "SELECT account.* FROM account where(account.fname like ('%" . $userData . "%') or account.lname like ('%" . $userData . "%')) or (account.email like ('%" . $userData . "%')) or (account.phone like ('%" . $userData . "%')) order by account.updated_at desc";
        return $this->paginate($sql);
    }

    // Phương thức mới cho chức năng quên mật khẩu
    public function saveResetToken($userId, $token, $expires)
    {
        $sql = "UPDATE account SET remember_token = '$token', updated_at = '$expires' WHERE id = $userId";
        return $this->_query($sql);
    }

    public function validateResetToken($token)
    {
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM account WHERE remember_token = '$token' AND updated_at > '$now'";
        $query = $this->_query($sql);
        return mysqli_num_rows($query) > 0;
    }

    public function getUserByResetToken($token)
    {
        $sql = "SELECT * FROM account WHERE remember_token = '$token'";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function updatePassword($userId, $password)
    {
        $sql = "UPDATE account SET password = '$password' WHERE id = $userId";
        return $this->_query($sql);
    }

    public function clearResetToken($userId)
    {
        $sql = "UPDATE account SET remember_token = NULL WHERE id = $userId";
        return $this->_query($sql);
    }
    
    // Phương thức mới cho xác thực email
    public function saveVerificationToken($userId, $token)
    {
        $sql = "UPDATE account SET verification_token = '$token' WHERE id = $userId";
        return $this->_query($sql);
    }
    
    public function verifyEmail($token)
    {
        $now = date('Y-m-d H:i:s');
        $sql = "UPDATE account SET email_verified_at = '$now', verification_token = NULL WHERE verification_token = '$token'";
        return $this->_query($sql);
    }
    
    public function isEmailVerified($userId)
    {
        $sql = "SELECT email_verified_at FROM account WHERE id = $userId";
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result && !empty($result['email_verified_at']);
    }
    
    public function getUserByVerificationToken($token)
    {
        $sql = "SELECT * FROM account WHERE verification_token = '$token'";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }
}
