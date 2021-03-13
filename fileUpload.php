<html>
<head>
	<title>file upload</title>
</head>
    <style>
        input[type="submit"]{
            width: 500px;
            height: 50px;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
        }
        .submit{
            width: 500px;
            margin: 10px auto;
        }
        .float{
            float: left;
        }
        input[type="text"]{
            width: 420px;
            height: 35px;
            font-size: 18px;
        }
        .box1 label{
            line-height: 45px;
        }
        .box{
            float: left;
            font-size: 18px;
            margin-left: 24px;
            margin-right: 14px;
        }
        .box label{
            line-height: 45px;
        }
        form{
            width: 1000px;
            height: auto;
            margin: 50px auto;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        form header{
            width: 980px;
            font-size: 22px;
            font-weight: 600;
            padding: 10px;
            background: lightgreen;
            color: #fff;
        }
        label.space{
            line-height: 45px;
            margin-left: 24px;
            font-size: 18px;
        }
        select{
            width: 930px;
            margin-left: 24px;
            height: 35px;
            font-size: 16px;
            padding: 5px 15px;
        }
        .file{
            position: relative;
            overflow: hidden;
            width: 90px;
            height: 32px;
            text-align: center;
            border: 1px solid #333;
        }
        .file input.upload{
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            text-align: center;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            height: 100%;
        }
        .file span{
            line-height: 30px;
            font-size: 20px;
        }
        .uploadf{
            width: 400px;
            padding: 6px;
            font-size: 16px;
        }
        #alert{
            width: 930px;
            border: 1px solid #333;
            margin: 15px 24px;
            height: 35px;
            display: none;
        }
        #alert #para{
            font-size: 16px;
            padding-left: 30px;
        }
    </style>
<body>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    	if (($_FILES['my_file']['name']!="")){
            $folder = "upload/";
			$file = $_FILES['my_file']['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $filedata = $_FILES['my_file']['tmp_name'];
            $folder_store_file = $folder.$filename.".".$ext;
            if(file_exists($folder_store_file)) {
                echo '<script>alert("File already exists")</script>'; 
            } else {
                move_uploaded_file($filedata,$folder_store_file);
                $model = $_POST["model"];
                $version = $_POST["version"];
                $date = date("Y-m-d");
                $con = new mysqli("localhost","root","","GramworkX");
                $sql = "insert into FileUploadTable(model,version,filedata,date) values('$model','$version','$filename','$date')";
                if($con->query($sql)){
                    echo '<script type="text/javascript">';
                    echo "alert('Device Firmware Updated')";
                    echo  '</script>';           
                }
            }
		}
        
    }
    ?>

	<form name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
        <header>GramworkX File Upload</header>
        <div id="alert">
        </div>
        <label class="space">Device Model</label><br>
        <select name="model" required>
          <option> -- Select Device --</option>
          <option value="gwx100">GWX100</option>
          <option value="gwx200">GWX200</option>
        </select><br>
        <div class="box">
            <label>Firmware Version</label><br>
            <input type="text" name="version" required>
        </div>
        <div class="box1">
            <label>Select Firmware</label><br>
            <div class="float">
               <input id="uploadFile" class="uploadf" placeholder="Choose File" disabled="disabled" >
            </div>
		    <div class="file">
                <span>Browse</span>
                <input type="file" id="upload" name="my_file" class="upload" required>
            </div>
        </div><br><br>
        <div class="submit">
            *All fields are mandatory<br>
            <input type="submit" name="submit" value="UPDATE NEW FIRMWARE"/>
        </div><br>
	</form><br><br>
    
    
</body>
    <?php
     $con = new mysqli("localhost","root","","GramworkX");
      $sqlquery = "select * from FileUploadTable";
            $result = $con->query($sqlquery);
            if($result->num_rows > 0){
                echo "<div class='container'>";
                    echo "<h1>Firmware Table</h1>";
                    echo "<table>";
                    echo "<tr>
                            <th>GWX</th>
                            <th>Firmware</th>
                            <th>File Path</th>
                            <th>Created At</th>
                          </tr>";
                while($row = $result->fetch_assoc()){
                            echo "<tr>";
                                    echo "<td>";
                                    echo $row["model"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["version"];
                                    echo "</td>";
                                    echo "<td class='padding'>";
                                    echo $row["filedata"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["date"];
                                    echo "</td>";
                            echo "</tr>";           
                }
                 echo "</table>";
                echo "<br>";
                    echo "</div><br><br>";
            }
    ?>
    <style>
        .container{
            width: 1650px;
            height: auto;
            margin: 10px auto;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .container > h1{
            width: 1625px;
            height: 50px;
            padding-left: 25px;
            line-height: 50px;
            background: lightgreen;
        }
        table{
            margin: 10px 20px;
            border-collapse: collapse;
        }
        table tr th,td{
            border: 1px solid #a7a7a7;
            padding: 10px;
        }
        table tr td{
            width: 200px;
            padding-left: 25px;
        }
        table tr td.padding{
            width: 950px;
        }
    </style>
</html>