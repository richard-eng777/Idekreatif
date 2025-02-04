<?php
include 'config.php';

session_start();

$userId = $_SESSION["user_id"];

if(isset($_POST['simpan'])) {
    $postTitle = $_POST["post_title"];
    $content = $_POST["content"];
    $categoryId = $_POST["category_id"];

    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"];
    $imagePath = $imageDir . basename($imageName);

    if(move_uploaded_file($_FILES["image"]["tmp_name"],$imagePath)){
        $query = "INSERT INTO posts (post_title, content, created_at, category_id, user_id, image_path) VALUES('$postTitle','$content', NOW(), $category, $userId, '$imagePath')";
        if($conn->query($query) === TRUE) {

            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Post succesfully added.'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Error adding post: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Failed to upload image.'
        ];
    }
    header('Location: dashboard.php');
    exit();
}
?>