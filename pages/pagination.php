<nav aria-label="...">
    <ul class="pagination">
        <?php
        // Hiển thị liên kết đến trang đầu
        if ($current_page > 1) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="?category_id=' . $category_id . '&per_page=' . $item_per_page . '&page=1">Đầu</a>';
            echo '</li>';
        }

        // Hiển thị trang trước đó (nếu có)
        if ($current_page > 1) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="?category_id=' . $category_id . '&per_page=' . $item_per_page . '&page=' . ($current_page - 1) . '"><span aria-hidden="true">&laquo;</span></a>';
            echo '</li>';
        }

        // Hiển thị các trang được phép
        $start_page = max(1, $current_page - 2);
        $end_page = min($totalPages, $current_page + 2);
        for ($page = $start_page; $page <= $end_page; $page++) {
            echo '<li class="page-item' . ($current_page == $page ? ' active' : '') . '">';
            echo '<a class="page-link" href="?category_id=' . $category_id . '&per_page=' . $item_per_page . '&page=' . $page . '">' . $page . '</a>';
            echo '</li>';
        }

        // Hiển thị trang kế tiếp (nếu có)
        if ($current_page < $totalPages) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="?category_id=' . $category_id . '&per_page=' . $item_per_page . '&page=' . ($current_page + 1) . '"><span aria-hidden="true">&raquo;</span></a>';
            echo '</li>';
        }

        // Hiển thị liên kết đến trang cuối
        if ($current_page < $totalPages) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="?category_id=' . $category_id . '&per_page=' . $item_per_page . '&page=' . $totalPages . '">Cuối</a>';
            echo '</li>';
        }
        ?>
    </ul>
</nav>
