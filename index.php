<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Shortlink</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<div id="container">
	<h1>Short URL</h1>

	<div id="body">
		<p></p>
		    <input type="text" id="url" name="url"></input>
		    <input type="button" name="submit" id="submit" value="Кнопка" onClick="getdetails()"></input>
		<p></p>
	</div>
	<?php
    $servername = "localhost";
    $database = "shortlink";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, $database);
    $sql = 'select * from short_tab order by "id" LIMIT 10';
    $result = mysqli_query($conn,$sql);
    
    if($result) {
    $rows = mysqli_num_rows($result);
    echo "<table><tr><th>Id</th><th>ссылка</th><th>short</th></tr>";
    for ($i = 0 ; $i < $rows ;$i++) {
        $row = mysqli_fetch_row($result);
        echo "<tr>";
            for ($j = 0 ; $j < 3 ; $j++) {
if($j == 0) echo "<td>$row[0]</td>";
if($j == 1) echo '<td><a target="_blank" href="http://'.$row[1].'/">http://'.$row[1].'/</a></td>';
if($j == 2) echo '<td><a target="_blank" href="http://localhost/shortlink1/'.$row[2].'">http://localhost/shortlink1/'.$row[2].'/</a></td>';
            }
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
    }
?>
</div>
<div class="popup" id="popup">
  <span class="popuptext" id="myPopup"></span>
</div>


<script>
function getdetails(){
    var name = $('#url').val();
    $.ajax({
        type: "POST",
        url: "details.php",
        data: {url:name}
    }).done(function(result)
        {
            var popup = $("#myPopup");
            popup.html(result);
            popup.addClass("show");
        });
}
</script>
</body>
</html>