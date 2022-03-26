<?php
if (isset($_POST['convert']))
    uploadImage();

function uploadImage()
{
    $targetFolder = "uploads/";
    $targetFile = $targetFolder . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        if (convertImage($targetFile, $imageFileType, $_POST['quality'])) {
            echo "Successfully uploaded";
            return;
        }
    }
}

function convertImage($file, $mime, $quality)
{
    $im = imagecreatefromjpeg($file);
    $newImagePath = str_replace($mime, "webp", $file);
    $quality = $quality;
    return imagewebp($im, $newImagePath, $quality);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" style="display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="range" name="quality" id="rangeInput" value="80" min="1" max="100" oninput="rangeInputVal.value = rangeInput.value">
        <output name="ageOutputName" id="rangeInputVal">80</output>
        <button type="submit" name="convert">Convert</button>
    </form>
</body>

</html>