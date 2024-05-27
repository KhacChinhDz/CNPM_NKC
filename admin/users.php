<?php 
include 'db_connect.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> Người dùng mới</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card col-lg-12">
            <div class="card-body">
                <table class="table-striped table-bordered col-md-12">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tên</th>
                            <th class="text-center">Tên người dùng</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = $conn->query("SELECT * FROM users order by name asc");
                        $i = 1;
                        while($row= $users->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['username'] ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Hành động</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Sửa</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Xoá</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$('#new_user').click(function(){
    uni_modal('Người dùng mới', 'manage_user.php');
});

$('.edit_user').click(function(){
    uni_modal('Sửa người dùng', 'manage_user.php?id=' + $(this).attr('data-id'));
});

$('.delete_user').click(function(){
    _conf("Bạn có chắc muốn xoá người dùng này?", "delete_user", [$(this).attr('data-id')]);
});

function delete_user(id) {
    $.ajax({
        url: 'delete_user.php',
        method: 'POST',
        data: {id: id},
        success: function(resp){
            resp = JSON.parse(resp);
            if (resp.status == 'success') {
                alert_toast("Xoá người dùng thành công", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Xoá người dùng thất bại", 'error');
            }
        },
        error: function(err){
            console.log(err);
            alert_toast("Xoá người dùng thất bại", 'error');
        }
    });
}

function _conf(msg, func, params) {
    if(confirm(msg)) {
        window[func](...params);
    }
}

function alert_toast(msg, type) {
    let bgColor;
    switch(type) {
        case 'success':
            bgColor = 'green';
            break;
        case 'error':
            bgColor = 'red';
            break;
        default:
            bgColor = 'blue';
    }
    let toast = document.createElement('div');
    toast.style.backgroundColor = bgColor;
    toast.innerHTML = msg;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.padding = '10px';
    toast.style.color = 'white';
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
