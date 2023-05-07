<?php

class BannerModel extends BaseModel
{
    const TABLE = 'banner';

    public function getAll($select = ['*'], $orderBys = [], $limit = 15)
    {
        return $this->all(self::TABLE, $select, $orderBys, $limit);
    }

    public function getAllBannerPaginate()
    {
        $sql = "SELECT * FROM " . self::TABLE . " order by id ASC";
        return $this->paginate($sql);
    }


    public function findBannerById($select = ['*'], $id)
    {
        return $this->find(self::TABLE, $select, $id);
    }

    public function findBannerBySite($site)
    {

        // $sql = "SELECT `image` FROM" . self::TABLE . "where `site` = ${site}  order by `priority` ASC";
        $sql = "SELECT image FROM banner where site = '$site' and status = 1  order by priority ASC";
        return $this->getByQuery($sql);
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

    public function searchBannerFull($bannerData)
    {
        $sql = "SELECT * from banner
                where (banner.name like ('%" . $bannerData . "%') or image like ('%" . $bannerData . "%')
                        or site like ('%" . $bannerData . "%') or description like ('%" . $bannerData . "%')) 
             order by id desc";
        return $this->paginate($sql);
    }
}
