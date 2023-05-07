<?php

class Paginator extends Database
{

    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;

    public function __construct($query)
    {
        $this->_conn = $this->connect();
        $this->_query = $query;
        $rs = $this->_conn->query($this->_query);
        $this->_total = $rs->num_rows;
    }


    public function getData($limit = 6, $page = 1)
    {

        $this->_limit   = $limit;
        $this->_page    = $page;

        if ($this->_limit == 'all') {
            $query      = $this->_query;
        } else {
            $query      =  $this->_query . " LIMIT " . (($this->_page - 1) * $this->_limit) . ", $this->_limit";
        }

        // print_r($query);
        $rs             = mysqli_query($this->_conn, $query);

        $results = [];
        while ($row = mysqli_fetch_assoc($rs)) {
            array_push($results, $row);
        }

        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = $results;
        // print_r($results);
        return $result;
    }

    public function createLinks($links, $list_class)
    {
        $module = empty($_GET['module']) ? '' : 'module=' . $_GET['module'] . '&';
        $controller = $_GET['controller'] ?? '';
        $action = empty($_GET['action']) || $_GET['action'] == 'delete' ? 'index' : $_GET['action'];
        if ($this->_limit == 'all') {
            return '';
        }
        $curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
        // links: so page dc hien thi truoc hoac sau dau ...
        $last       = ceil($this->_total / $this->_limit);

        $start      = (($this->_page - $links) > 0) ? $this->_page - $links : 1;
        $end        = (($this->_page + $links) < $last) ? $this->_page + $links : $last;

        $html       = "<nav class='blog-pagination d-flex align-items-center justify-content-center'>";
        $html       .= '<ul class="' . $list_class . '">';

        $class      = ($this->_page == 1) ? "disabled" : "";
        $html       .= '<li class="page-item ' . $class . '"><a class="page-link" href="./?' . $module . 'controller' . '=' . $controller . '&action=' . $action . '&limit=' . $this->_limit . '&page=' . ($this->_page - 1) . '"><i class="ti ti-angle-left"></i></a></li>';
        // print($last . " " . $start . " " . $end . " " . $links);
        if ($start > 1) {
            $html   .= '<li class="page-item" ><a class="page-link" href="./?' . $module . 'controller' . '=' . $controller . '&action=' . $action . '&limit=' . $this->_limit . '&page=1">1</a></li>';
            $html   .= '<li class="disabled"><span class="page-link">...</span></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            $class  = ($this->_page == $i) ? "active" : "";
            $html   .= '<li class="page-item ' . $class . '"><a class="page-link" href="./?' . $module . 'controller' . '=' . $controller . '&action=' . $action . '&limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            $html   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            $html   .= '<li><a class="page-link" href="./?' . $module . 'controller' . '=' . $controller . '&action=' . $action . '&limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
        }

        $class      = ($this->_page == $last) ? "disabled" : "";
        $html       .= '<li class="page-item ' . $class . '"><a class="page-link" href="./?' . $module . 'controller' . '=' . $controller . '&action=' . $action . '&limit=' . $this->_limit . '&page=' . ($this->_page + 1) . '"><i class="ti ti-angle-right"></i></a></li>';

        $html       .= '</ul></nav>';

        return $html;
    }
}
