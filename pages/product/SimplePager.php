<?php

class SimplePager {
    public $limit;      // Page size
    public $page;       // Current page
    public $item_count; // Total item count
    public $page_count; // Total page count
    public $result;     // Result set (array of records)
    public $count;      // Item count on the current page

    public function __construct($query, $params, $limit, $page) {
        global $_db;
        
        // Set [limit] and [page]
        $this->limit = ctype_digit($limit) ? max($limit, 1) : 3;
        $this->page = ctype_digit($page) ? max($page, 1) : 1;

        // Set [item count]
        $q = preg_replace('/SELECT.+FROM/', 'SELECT COUNT(*) FROM', $query, 1);
        $stm = $_db->prepare($q);
        $stm->execute($params);
        $this->item_count = $stm->fetchColumn();

        // Set [page count]
        $this->page_count = ceil($this->item_count / $this->limit);

        // Calculate offset
        $offset = ($this->page - 1) * $this->limit;

        // Set [result]
        $stm = $_db->prepare($query . " LIMIT $offset, $this->limit");
        $stm->execute($params);
        $this->result = $stm->fetchAll();

        // Set [count]
        $this->count = count($this->result);
    }

    public function html($href = '', $attr = '') {
        global $order;
        global $search;
        global $min_price;
        global $max_price;
        if($search){
            if (!$this->result) return;
            // Generate pager (html)
            $prev = max($this->page - 1, 1);
            $next = min($this->page + 1, $this->page_count);
    
            echo "<ul class='pager' $attr>";
            echo "<a href='?page=1&dir=$order&search=$search&min=$min_price&$max_price&$href'>First</a>";
            echo "<a href='?page=$prev&dir=$order&search=$search&min=$min_price&$max_price&$href'>Previous</a>";
    
            for ($p = 1; $p <= $this->page_count; $p++) {
                $c = $p == $this->page ? 'active' : '';
                echo "<a href='?page=$p&dir=$order&search=$search&min=$min_price&$max_price&$href' class='$c'>$p</a>";
            }
    
            echo "<a href='?page=$next&dir=$order&search=$search&min=$min_price&$max_price&$href'>Next</a>";
            echo "<a href='?page=$this->page_count&dir=$order&search=$search&min=$min_price&$max_price&$href'>Last</a>";
            echo "</ul>";
        }else{
        if (!$this->result) return;
        // Generate pager (html)
        $prev = max($this->page - 1, 1);
        $next = min($this->page + 1, $this->page_count);

        echo "<ul class='pager' $attr>";
        echo "<a href='?page=1&dir=$order&min=$min_price&$max_price&$href'>First</a>";
        echo "<a href='?page=$prev&dir=$order&min=$min_price&$max_price&$href'>Previous</a>";

        for ($p = 1; $p <= $this->page_count; $p++) {
            $c = $p == $this->page ? 'active' : '';
            echo "<a href='?page=$p&dir=$order&min=$min_price&$max_price&$href' class='$c'>$p</a>";
        }

        echo "<a href='?page=$next&dir=$order&min=$min_price&$max_price&$href'>Next</a>";
        echo "<a href='?page=$this->page_count&dir=$order&min=$min_price&$max_price&$href'>Last</a>";
        echo "</ul>";
    }
}
}