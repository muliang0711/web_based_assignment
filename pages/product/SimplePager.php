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
        $this->limit = ctype_digit($limit) ? (int)max($limit, 1) : 10;
        $this->page = ctype_digit($page) ? (int)max($page, 1) : 1;

        // Set [item count]
        $q = preg_replace('/SELECT.+FROM/', 'SELECT COUNT(*) FROM', $query, 1);
        $stm = $_db->prepare($q);
        $stm->execute($params);
        $this->item_count = (int)$stm->fetchColumn();

        // Set [page count]
        $this->page_count = ceil($this->item_count / $this->limit);

        // If somehow $this->page exceeds the number of pages there is, just treat it as though user requested for the last page
        if ($this->page > $this->page_count) {
            $this->page = max($this->page_count, 1); // In case $this->page_count = 0 (due to item_count being 0), $this->page should be 1 to prevent $offset becoming a negative number, which causes SQL syntax error in the following code
        }

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
        // global $order;
        // global $search;
        // global $min_price;
        // global $max_price;
        // if($search){
        //     if (!$this->result) return;
        //     // Generate pager (html)
        //     $prev = max($this->page - 1, 1);
        //     $next = min($this->page + 1, $this->page_count);
    
        //     echo "<ul class='pager' $attr>";
        //     echo "<a href='?page=1&dir=$order&search=$search&min=$min_price&max=$max_price&$href'>First</a>";
        //     echo "<a href='?page=$prev&dir=$order&search=$search&min=$min_price&max=$max_price&$href'>Previous</a>";
    
        //     for ($p = 1; $p <= $this->page_count; $p++) {
        //         $c = $p == $this->page ? 'active' : '';
        //         echo "<a href='?page=$p&dir=$order&search=$search&min=$min_price&max=$max_price&$href' class='$c'>$p</a>";
        //     }
    
        //     echo "<a href='?page=$next&dir=$order&search=$search&min=$min_price&max=$max_price&$href'>Next</a>";
        //     echo "<a href='?page=$this->page_count&dir=$order&search=$search&min=$min_price&max=$max_price&$href'>Last</a>";
        //     echo "</ul>";
        // }else{
        if (!$this->result) return;

        // Generate pager (html)
        $prev = max($this->page - 1, 1);
        $next = min($this->page + 1, $this->page_count);

        echo "<ul class='pager' $attr>";
        echo "<a href='?page=1&$href'>First</a>";
        echo "<a href='?page=$prev&$href'>Previous</a>";

        $num_links = 5;
        $first_link = max(1, min($this->page_count - $num_links + 1, $this->page - 2)); // x = $this->page - 2, 1 <= x <= $this->page_count - $num_links + 1
        if ($this->page_count < $num_links) {
            $last_link = $this->page_count;
        }
        else {
            $last_link  = max($num_links, min($this->page_count, $this->page + 2));         // y = $this->page + 2, $num_links <= y <= $this->page_count
        }

        for ($p = $first_link; $p <= $last_link; $p++) {
            $c = $p == $this->page ? 'active' : '';
            echo "<a href='?page=$p&$href' class='$c'>$p</a>";
        }

        echo "<a href='?page=$next&$href'>Next</a>";
        echo "<a href='?page=$this->page_count&$href'>Last</a>";
        echo "</ul>";
    }
}
// }