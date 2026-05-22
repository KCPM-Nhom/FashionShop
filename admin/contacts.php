<?php
session_start();
include('../config/database.php');

// Xử lý Xóa tin nhắn
if (isset($_GET['delete_id'])) {
    $del_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM contacts WHERE id = $del_id");
    header("Location: contacts.php");
    exit();
}

// Xử lý Đánh dấu đã đọc
if (isset($_GET['read_id'])) {
    $read_id = (int)$_GET['read_id'];
    mysqli_query($conn, "UPDATE contacts SET status = 'read' WHERE id = $read_id");
    header("Location: contacts.php");
    exit();
}

$sql_contacts = "SELECT * FROM contacts ORDER BY created_at DESC";
$res_contacts = mysqli_query($conn, $sql_contacts);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Liên Hệ - FashionShop</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="admin-wrapper">
        <?php include('sidebar.php'); ?>

        <main class="main-content">
            <header>
                <h1>Tin Nhắn Từ Khách Hàng</h1>
            </header>
            <section class="recent-orders">
                <table>
                    <thead>
                        <tr>
                            <th>Ngày gửi</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th style="width: 40%;">Nội dung</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($res_contacts) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($res_contacts)): ?>
                                <tr style="<?php echo ($row['status'] == 'new') ? 'font-weight: bold; background: #f4f6f9;' : ''; ?>">
                                    <td><?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                    <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'new'): ?>
                                            <a href="contacts.php?read_id=<?php echo $row['id']; ?>" class="btn-edit green" style="color:white; text-decoration:none; padding:5px; border-radius:3px; margin-right:5px;"><i class="fa fa-check"></i> Đã đọc</a>
                                        <?php endif; ?>
                                        <a href="contacts.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Xóa tin nhắn này?');" class="btn-edit red" style="color:white; text-decoration:none; padding:5px; border-radius:3px;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px;">Không có tin nhắn nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>