<?php
session_start();
$con=mysqli_connect("localhost","root","");
if(!$con)
{
    die('Could not connect: '.mysqli_error());
}
mysqli_select_db($con,"barcode");
$statusmsg="";

$targetDir="uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"]))
{
    $allowTypes=array('png','jpg','jpeg','txt','pptx','pdf','xlsx','bmp');
    if(in_array($fileType, $allowTypes))
    {
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
        {
            $insert = "INSERT INTO tb_filecode39(file_name,upload_on) VALUES ('$targetFilePath',NOW())";
            if(mysqli_query($con,$insert))
            {
                $statusMsg = "The file ".$targetFilePath. " has been uploaded successfully.";
            }
            else
            {
                $statusMsg = "File upload failed, please try again.";
            } 
        }
        else
        {
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }
    else
    {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, PPTX, XLSX, TXT, BMP & PDF files are allowed to upload.';
    }
}
else
{
    $statusMsg = 'Please select a file to upload.';
}
echo $statusMsg;
$_SESSION['filename']=$targetFilePath;
?>
<html>
<body>
<h3><a href="uploadfile.php">Back to Upload page</a></h3>
<form action="qrcode.php" method="post">
<input type="submit" value="Generate QR Code" name="submit"/>
</form>
</body>
</html>