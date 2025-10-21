<?php
session_start();
include "../../app/config.php";
$user_sessoin = $_SESSION['username'];
$idUser_sesion = $_SESSION['user_id'];



if (isset($_POST['save'])) {
    $name = $_POST['name'] ?? '';
    $categorie = $_POST['categories'] ?? '';
    $screen_tech = $_POST['screen_tech'] ?? '';
    $screen_size = $_POST['screen_size'] ?? '';
    $camera_front = $_POST['camera_front'] ?? '';
    $camera_back = $_POST['camera_back'] ?? '';
    $battery = $_POST['battery'] ?? '';
    $sim = $_POST['sim'] ?? '';
    $desc = $_POST['desc'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $os = $_POST['os'] ?? '';
    $main_image = "";
    $status = $_POST['status'];
    $upload_dir = "../../public/assets/img/product/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!empty($_FILES['anh_chinh']['name'])) {
        $fileName = time() . "_" . basename($_FILES['anh_chinh']['name']);
        $targetFile = $upload_dir . $fileName;

        if (move_uploaded_file($_FILES['anh_chinh']['tmp_name'], $targetFile)) {
            $main_image = $fileName;
        }
    }

    $sub_images = [];
    if (!empty($_FILES['anh_phu']['name'][0])) {
        foreach ($_FILES['anh_phu']['name'] as $key => $value) {
            $fileName = time() . "_" . $key . "_" . basename($value);
            $targetFile = $upload_dir . $fileName;

            if (move_uploaded_file($_FILES['anh_phu']['tmp_name'][$key], $targetFile)) {
                $sub_images[] = $fileName;
            }
        }
    }


    $checkName = $conn->query("SELECT * FROM products WHERE name = '$name' LIMIT 1");
    if (empty($name) || empty($categorie) || empty($screen_tech) || empty($screen_size) || empty($camera_front) || empty($camera_back) || empty($battery) || empty($sim) || empty($desc) || empty($brand) || empty($os)) {
        $_SESSION['modal_title'] = "Thiếu thông tin";
        $_SESSION['modal_message'] = "Lổi thiếu thông tin sản phẩm!";
        $_SESSION['modal_type'] = "error";
    } else if ($checkName->num_rows > 0) {
        $_SESSION['modal_title'] = "Sản phẩm đã tồn tại";
        $_SESSION['modal_message'] = "Sản phẩm <b>$name</b> đã tồn tại trong hệ thống!";
        $_SESSION['modal_type'] = "error";
    } else {
        $result = $conn->query("INSERT INTO products(name, screen_technology, screen_size, front_camera, rear_camera, battery_capacity, categories, img_main, sim_card, description, brand_id, os_id, status) VALUES('$name','$screen_tech','$screen_size','$camera_front','$camera_back','$battery','$categorie','$main_image','$sim','$desc', $brand, $os, $status)");
        if ($result) {
            $product_id = $conn->insert_id;

            foreach ($sub_images as $img) {
                $conn->query("INSERT INTO product_images(product_id, image_url, is_main) VALUES('$product_id', '$img', 0)");
            }

            $_SESSION['modal_title'] = "Thêm sản phẩm thành công";
            $_SESSION['modal_message'] = "Bạn đã thêm sản phẩm <b>$name</b> thành công";
            $_SESSION['modal_type'] = "success";
            $_SESSION['product_id'] = $product_id;
            $user_id = $idUser_sesion;
            $username = $user_sessoin;
            $desc = "Người dùng $username đã thêm sản phẩm: $name";
            $desc = $conn->real_escape_string($desc);

            $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
                        VALUES ('$user_id', 'INSERT', 'product', '$desc')";
            $conn->query($sql_log);
        } else {
            $_SESSION['modal_title'] = "Thông báo lỗi";
            $_SESSION['modal_message'] = "Thêm sản phẩm thất bại!";
            $_SESSION['modal_type'] = "error";
        }
    }
    header("Location: ../add_product.php");
    exit;
}

if (isset($_POST['update'])) {
    $productID = $_POST['productID'] ?? '';
    $name = $_POST['name'] ?? '';
    $categorie = $_POST['categories'] ?? '';
    $screen_tech = $_POST['screen_tech'] ?? '';
    $screen_size = $_POST['screen_size'] ?? '';
    $camera_front = $_POST['camera_front'] ?? '';
    $camera_back = $_POST['camera_back'] ?? '';
    $battery = $_POST['battery'] ?? '';
    $sim = $_POST['sim'] ?? '';
    $desc = $_POST['desc'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $os = $_POST['os'] ?? '';
    $status = $_POST['status'];
    if (empty($name) || empty($categorie) || empty($screen_tech) || empty($screen_size) || empty($camera_front) || empty($camera_back) || empty($battery) || empty($sim) || empty($desc) || empty($brand) || empty($os)) {
        $_SESSION['modal_title'] = "Thiếu thông tin sản phẩm";
        $_SESSION['modal_message'] = "Vui lòng xem lại các trường dữ liệu!";
        $_SESSION['modal_type'] = "error";
    } else {
        $sqlOrder = "UPDATE products SET name = '$name', screen_technology = '$screen_tech', screen_size = '$screen_size', front_camera = '$camera_front', rear_camera = '$camera_back',battery_capacity = '$battery',categories = '$categorie',sim_card = '$sim', description = '$desc',brand_id = '$brand',os_id = '$os', status = '$status' WHERE id = $productID";
        if ($conn->query($sqlOrder)) {
            $_SESSION['modal_title'] = "Cập nhật thành công!";
            $_SESSION['modal_message'] = "Bạn đã cập nhật thành công sản phẩm🎉";
            $_SESSION['modal_type'] = "success";
        } else {
            $_SESSION['modal_title'] = "Cập nhật thất bại!";
            $_SESSION['modal_message'] = "Cập nhật sản phẩm thất bại vui lòng xem đầy đủ thông tin!";
            $_SESSION['modal_type'] = "error";
        }
    }

    header("Location: ../add_product.php?edit=$productID");
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $queryProduct = "UPDATE products SET status = 1, is_delete = 1 WHERE id = $id";
    $conn->query($queryProduct);
    $query_product_varian = "UPDATE product_variants  SET status = 1, is_deleted = 1 WHERE product_id = 26;
    ";
    $conn->query($query_product_varian);

    $_SESSION['modal_title'] = "Đã xóa sản phẩm!";
    $_SESSION['modal_message'] = "Sản phẩm và toàn bộ biến thể đã được chuyển vào trạng thái xóa mềm.";
    $_SESSION['modal_type'] = "success";

    header("Location: ../products.php");
    exit;
}
