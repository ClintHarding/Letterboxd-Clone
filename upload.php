<?php
session_start();
define("IN_CODE", 1);
include_once 'dbconfig.php';
$uid = $_SESSION['user_id'];

$conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
    mysqli_connect_error()); //create dbname variable and dbconfig

if (isset($_POST['submit'])) {

	$file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        //Get File Extension type
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        //Allow Only JPEGS and PNGS
        $allowed = array('jpg','jpeg');

        // Error Checking
        if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                        if ($fileSize < 1000000) {
                                $fileNameNew = "profile".$uid.".".$fileActualExt;
                                $fileDestination = 'uploads/' . $fileNameNew;
                                move_uploaded_file($fileTmpName, $fileDestination);
                                $sql = "UPDATE profileimg SET status=0 WHERE userid= '$uid';";
                                $result = mysqli_query($conn, $sql);
                                header("Location: profile.php?uploadsuccess");
                        }
                        else {
                                echo "Your file is too big!";
                        }

                }
                else {
                        echo "There was an error uploading your file!";
                }
        }
        else {
                echo "You cannot upload files of this type!";
        }

}

?>
