<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($alert_title) ? $alert_title : 'Thông báo'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php
    // Mặc định màu sắc nếu không truyền vào (success = xanh lá, danger = đỏ)
    $theme = isset($alert_theme) ? $alert_theme : 'success';
    $btn_color = ($theme == 'success') ? '#198754' : '#dc3545';
    ?>

    <div class="modal fade" id="dynamicModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-<?php echo $theme; ?> text-white">
                    <h5 class="modal-title fw-bold">
                        <?php echo isset($alert_title) ? $alert_title : 'Thông báo'; ?>
                    </h5>
                </div>
                <div class="modal-body fs-5 mt-3 mb-3 text-center">
                    <?php echo isset($alert_message) ? $alert_message : 'Đã xử lý thành công!'; ?>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="<?php echo isset($redirect_url) ? $redirect_url : '#'; ?>"
                        class="btn btn-<?php echo $theme; ?> px-4 py-2"
                        style="background-color: <?php echo $btn_color; ?>; border: none;">
                        Xác nhận
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById("dynamicModal"));
            myModal.show();
        });
    </script>
</body>

</html>