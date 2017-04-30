<!doctype HTML>
<html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
    <title>Dats04 - Student</title>
</head>

<body>
<div class="title">
    <h1>HiOA student information system</h1>
</div>

<div>
    <a class="navigation" href="index.php">Home</a>
    <a class="currentpage" href="student.php">Student</a>
    <a class="navigation" href="course.php">Course</a>
    <a class="navigation" href="studyprogram.php">Study Program</a>
</div>

<div class="siteinfo">
    <p></p>
</div>

<div class="siteinfo">
<?php
ob_start();
ini_set('display_errors',1);
$stID=$_GET['stID'];
//Connection to dats04-dbproxy
$host="10.1.1.130";
$user="webuser";
$pw="welcomeunclebuild";
$db="studentinfosys";
$dbconn = new mysqli($host, $user, $pw, $db);

$getTitle="select progcode, title from Study_program group BY title;";
$getTitlecourse = $dbconn->query($getTitle);

echo "<form id=\"selectprogram\" method=\"GET\">
        <select name=\"progcode\">";
while($row=$getTitlecourse->fetch_assoc()){
    echo "<option value=\"{$row['progcode']}\" name='progcode'>{$row['title']}</option>";
}
echo "</select>
        <input type='hidden' name='stID' value='$stID'>
        <input class=\"dblock\" type=\"Submit\" value=\"Submit\">
    </form>";

function selectYear($stID,$progcode){
    echo "<form id=\"selectYear\" method=\"GET\">
        <select name=\"year\">";
    $i=2017;
    while($i>1900){
        echo "<option value=\"$i\" name='year'>$i<option>";
        $i--;
    }
    echo "</select>
        <input type='hidden' name='progcode' value='$progcode'>
        <input type='hidden' name='stID' value='$stID'>
        <input class=\"dblock\" type=\"Submit\" value=\"Submit\">
    </form>";
}

function insertProgram($dbconn, $stID, $progcode, $year){
    $insert="insert into Enrollment values ($stID,'$progcode',$year);";
    if ($dbconn->query($insert)===TRUE){
        echo "<p>Succesfully added the course to student $stID</p>";
    }else {
        echo "<p>Something went wrong. The course was not added to student $stID</p>";
    }
}


if (isset($_GET["progcode"])){
    selectYear($_GET['stID'],$_GET['progcode']);
}
if (isset($_GET["year"])){
    insertProgram($dbconn, $_GET['stID'],$_GET['progcode'],$_GET['year']);
}

?>
</div>

</body>

<footer class="bottomofpage">
    <?php
    echo "The web server IP:" . $_SERVER['SERVER_ADDR'] . " port: " . $_SERVER['SERVER_PORT'] . "<br>";
    echo "The database server IP:" . $dbconn->host_info . "<br>";
    $dbconn->close();
    ?>
</footer>
</html>
