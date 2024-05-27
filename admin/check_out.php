<?php 
include('db_connect.php'); 

// Fetch and store room categories
$cat = $conn->query("SELECT * FROM room_categories");
$cat_arr = array();
while($row = $cat->fetch_assoc()){
    $cat_arr[$row['id']] = $row;
}

// Fetch and store rooms
$room = $conn->query("SELECT * FROM rooms");
$room_arr = array();
while($row = $room->fetch_assoc()){
    $room_arr[$row['id']] = $row;
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Danh mục</th>
                                <th>Phòng</th>
                                <th>Giải quyết</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $checked = $conn->query("SELECT * FROM checked WHERE status != 0 ORDER BY status DESC, id ASC");
                                while($row = $checked->fetch_assoc()):
                                    $room_id = $row['room_id'];
                                    if (isset($room_arr[$room_id]['category_id']) && isset($cat_arr[$room_arr[$room_id]['category_id']]['name'])) {
                                        $category_name = $cat_arr[$room_arr[$room_id]['category_id']]['name'];
                                        $room_name = $room_arr[$room_id]['room'];
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($category_name) ?></td>
                                    <td class=""><?php echo htmlspecialchars($room_name) ?></td>
                                    <td class=""><?php echo htmlspecialchars($row['ref_no']) ?></td>
                                    <?php if($row['status'] == 1): ?>
                                        <td class="text-center"><span class="badge badge-warning">Vào</span></td>
                                    <?php else: ?>
                                        <td class="text-center"><span class="badge badge-success">Ra</span></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary check_out" type="button" data-id="<?php echo $row['id'] ?>">Xem</button>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                endwhile; 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('table').dataTable();
    $('.check_out').click(function(){
        uni_modal("Check Out", "manage_check_out.php?checkout=1&id=" + $(this).attr("data-id"));
    });
    $('#filter').submit(function(e){
        e.preventDefault();
        location.replace('index.php?page=check_in&category_id=' + $(this).find('[name="category_id"]').val() + '&status=' + $(this).find('[name="status"]').val());
    });
</script>
