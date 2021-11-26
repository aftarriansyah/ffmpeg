
<!DOCTYPE html>
<html>
<head>
  <title>Upload your files</title>
</head>
<body>
  <form enctype="multipart/form-data" action="index.php" method="POST">
    <p>Upload your file</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
  </form>
</body>
</html>
<?PHP
  if(!empty($_FILES['uploaded_file']))
  {
    $path = "uploads/";
    $path = $path . basename( $_FILES['uploaded_file']['name']);
    
    if($_FILES["uploaded_file"]["type"] != "video/mp4"){
      echo "only .mp4 file";
      echo $_FILES["uploaded_file"]["type"];
    }elseif(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
      " has been uploaded";
      $audioname = "audio_".md5(basename($_FILES['uploaded_file']['name'])).".mp3";
      $videoname = "video_".md5(basename($_FILES['uploaded_file']['name'])).".mp4";
      shell_exec("ffmpeg -i $path -c copy -an uploads/$videoname");
      shell_exec("ffmpeg -i $path -q:a 0 -map a uploads/$audioname");
      echo "Download Link:<br>";
      echo "<a href=\"uploads/$audioname\">$audioname</a><br>";
       echo "<a href=\"uploads/$videoname\">$videoname</a><br>";
      
    } else{
        echo "There was an error uploading the file, please try again!";
    }
  }
?>
