<?php
if(isset($_FILES) AND isset($_FILES['inputfile']) AND $_FILES['inputfile']['error'] == 0) {
    $destination_dir = dirname(__FILE__) . '/' . $_FILES['inputfile']['name'];
    move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir);
    $a = file_get_contents('https://api.eeshop.ru/radchenko/list.json');
    $b = json_decode($a);
    $b[] = array("title" => $_FILES['name'], "file" => $_FILES['name']);
    file_put_contents("list.json", json_encode($b));


    echo 'File Uploaded';
    header("refresh:3; https://api.eeshop.ru/radchenko/list.php");
}
else if (isset($_FILES['inputfile']) AND $_FILES['inputfile']['error'] != 0) {

    echo 'No File Uploaded'; 
}


?>
<html>
<head>
    <title>Basic File Upload</title>
</head>
<body>
<h1>Basic File Upload</h1>
<form method="post" action="admin.php" enctype="multipart/form-data">

    <input type="file" id="inputfile" name="inputfile"></br>
    <input type="submit" value="Click To Upload">
</form>
</body>
</html>