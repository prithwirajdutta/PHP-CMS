<html>
  <?php include('config.php'); ?>
  <?php
    include('config.php');
    if(isset($_POST['uploadsubmit'])){
        $target_file = "upload/"    . basename($_FILES["fileToUpload"]["name"]);
        $filename = basename($_FILES["fileToUpload"]["name"]);
        $desc=$_POST['description'];
        $query = "insert into filedetails(filename,filelocation,postdesc) values ('$filename','$target_file','$desc');";
        $result = mysqli_query($con,$query);
        if($result)
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
            {
                echo "<span style='z-index:10;line-height:40px;width:100%;height:40px;background-color:#2C3E50;color:white;text-align:center;position:fixed;top:0px;left:0px;'>The file has been uploaded</span>";
            } 
            else
            {
                echo "There was an error while uploading the file";
            } 
        }
    }
    if(isset($_POST['deletefile'])){
        $filename=$_POST['filenametobedeleted'];
        $query="delete from filedetails where filename='$filename';";
        $result=mysqli_query($con,$query);
        if($result)
        {
          unlink( "upload/".$filename); 
          echo "<span style='z-index:10;line-height:40px;width:100%;height:40px;background-color:#2C3E50;color:white;text-align:center;position:fixed;top:0px;left:0px;'>The file has been deleted.</span>"; 
        }
    }
?>
  <head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <div class="container" style="display:flex;flex-direction:column;justify-content:center;align-items:center;margin:40px;">
    <h4>Post Something !</h4>  
    <form action="index.php" enctype="multipart/form-data" method="post" style="width:800px;display:flex;flex-direction:column;">
        <div style="margin:10px;"><input type="file" name="fileToUpload" class="form-control"></div>
        <textarea name="description" class="form-control"></textarea>
        <div style="margin:10px;"><input type="submit" name="uploadsubmit" value="Post" class="btn btn-info"></div>
      </form>
      <div>
        <?php
        $query = "select * from filedetails";
        $result = mysqli_query($con,$query);
        echo '<div style="max-width:800px;display:flex;flex-direction:row;justify-content:center;align-items:center;flex-wrap:wrap;">';
        while($row=mysqli_fetch_array($result))
        {
            $filename = $row['filename'];
            $postdesc = $row['postdesc'];
            $filelocation = $row['filelocation'];
            echo '<div class="card" style="margin:10px;"><img src="'.$filelocation.'" width="200px" height="200px;"/>
            <p style="text-align:center;max-width:300px;">'.$postdesc.'</p>
            <form method="post" action="index.php" style="margin:6px;">
              <input type="hidden" name="filenametobedeleted" value="'.$filename.'"/>
              <input type="submit" name="deletefile" value="Delete" class="btn btn-danger"/>
            </form></div>';
        } 
        echo '</div>';
       ?>
      </div>
    </div>
  </body>
</html>