<?php
    include('config.php');
    if(isset($_POST['uploadsubmit'])){
        $target_file = "upload/"    . basename($_FILES["fileToUpload"]["name"]);
        $filename = basename($_FILES["fileToUpload"]["name"]);
        $query = "insert into filedetails(filename,filelocation) values ('$filename','$target_file');";
        $result = mysqli_query($con,$query);
        if($result)
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
            {
                echo "The file has been uploaded";
            } 
            else
            {
                echo "There was an error while uploading the file";
            } 
        }
    }
    if(isset($_POST['deletefile'])){
        unlink( "upload/"."spider-man-cartoon-png-favpng-2QHTDj1tZJpZYfHSzFNyAbR4M.jpg" );
        echo "File has been deleted";   
    }
?>

<html>
    <head></head>
    <body>
        <?php
            $query = "select * from filedetails";
            $result = mysqli_query($con,$query);
            while($row=mysqli_fetch_array($result))
            {
                $filelocation = $row['filelocation'];
                echo '<img src="'.$filelocation.'" width="200px" height="200px;"/>';
            } 
        ?>
    </body>
</html>