<?php

function short_link($name) {
    $servername = "localhost";
    $database = "shortlink";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, $database);
    $sql = 'select * from short_tab where link="'.$name.'"';
    $result = mysqli_query($conn,$sql);
    $row=mysqli_num_rows($result);
        if($row == 0) {
            $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
            $max=7; 
            $size=StrLen($chars)-1; 
            $short=null;
            while($max--) $short.=$chars[rand(0,$size)];
                $sql = 'select * from short_tab where short="'.$short.'"';
                $result = mysqli_query($conn,$sql);
                $row=mysqli_num_rows($result);
                if($row == 0) {
                    $sql = 'INSERT INTO short_tab (id, link, short, stats) VALUES (0,"'.$name.'","'.$short.'",0)';
                    $result = mysqli_query($conn,$sql);
                    $row=mysqli_fetch_array($result);
                    $f = fopen($short.'.php', "w");
                    fwrite($f, '<?php header("Location: http://'.$name.'/") ?>');
                    fclose($f);
                    echo '<a target="_blank" href="http://localhost/shortlink1/'.$short.'">http://localhost/shortlink1/'.$short.'</a>';
                } else {
                    $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
                    $max=7; 
                    $size=StrLen($chars)-1; 
                    $short=null;
                    while($max--) $short.=$chars[rand(0,$size)];
                }
        } else {
            $sql = 'select * from short_tab where link="'.$name.'"';
            $result = mysqli_query($conn,$sql);
            $row=mysqli_fetch_array($result);
            echo '<a target="_blank" href="http://localhost/shortlink1/'.$row['short'].'">http://localhost/shortlink1/'.$row['short'].'</a>';
        }
    mysqli_close($conn);
}

if($_POST["url"] != "") {
    $name = preg_replace('/\s+/', '', $_POST["url"]);
    $name = preg_replace("#/$#", "", $name);
    $name = preg_replace('#^http(s)?://#',"", $name);
    $name = preg_replace('/^www\./', '', $name);
    if(get_headers("http://".$name, 1)){
        short_link($name);
    } else {echo $name."Ссылка не валидна";}
} else {echo "Поле не может быть пустым";}
?>