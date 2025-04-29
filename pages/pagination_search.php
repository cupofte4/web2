<nav aria-label="...">
    <ul class="pagination">
        <?php if ($current_page > 1): ?>
        <li class="page-item">
            <a class="page-link"
                href="?per_page=<?php echo $item_per_page ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>&page=1&timkiem=<?php echo isset($_GET['timkiem']) ? $_GET['timkiem'] : '' ?>"
                aria-label="First">
                <span aria-hidden="true">Đầu</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link"
                href="?per_page=<?php echo $item_per_page ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>&page=<?php echo $current_page - 1 ?>&timkiem=<?php echo isset($_GET['timkiem']) ? $_GET['timkiem'] : '' ?>"
                aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php endif; ?>

        <?php
        // Hiển thị các trang xung quanh trang hiện tại và dấu "..." cho các trang còn lại
        $num_display_pages = 1; // Số trang hiển thị xung quanh trang hiện tại
        $start_page = max(1, $current_page - $num_display_pages);
        $end_page = min($totalPages, $current_page + $num_display_pages);

        // Hiển thị dấu "..." nếu cần
        $show_dots_start = ($start_page > 1);
        $show_dots_end = ($end_page < $totalPages);

        for ($page = $start_page; $page <= $end_page; $page++) {
            echo '<li class="page-item' . ($current_page == $page ? ' active' : '') . '">';
            echo '<a class="page-link" href="?per_page=' . $item_per_page . '&keyword=' . (isset($_GET['keyword']) ? $_GET['keyword'] : '') . '&page=' . $page . '&timkiem=' . (isset($_GET['timkiem']) ? $_GET['timkiem'] : '') . '">' . $page . '</a>';
            echo '</li>';
        }

        if ($show_dots_end) {
            echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
        }
        ?>

        <?php if ($current_page < $totalPages): ?>
        <li class="page-item">
            <a class="page-link"
                href="?per_page=<?php echo $item_per_page ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>&page=<?php echo $current_page + 1 ?>&timkiem=<?php echo isset($_GET['timkiem']) ? $_GET['timkiem'] : '' ?>"
                aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link"
                href="?per_page=<?php echo $item_per_page ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : $_GET['name'] ?>&page=<?php echo $totalPages ?>&timkiem=<?php echo isset($_GET['timkiem']) ? $_GET['timkiem'] : '' ?>"
                aria-label="Last">
                <span aria-hidden="true">Cuối</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>