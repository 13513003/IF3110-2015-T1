<?php
require_once("./sql/mysql.php");
?>

<?php
$db = new mysqli('localhost','root','','StackExchange');
$id = isset($_GET['id']) ? $_GET['id'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type="text/css" href="css/style.css">
    <h1> Simple Stack Exchange </h1>
</head>
<?php
$q = "SELECT * from question where id=$id ";
if(!$result = $db -> query($q)){
    die('Error Query ['.$db -> error. ']');
}
else{
    $row = $result->fetch_assoc();
}
?>
<div class="question_section">
    <h2><?php echo $row['topic'] ?></h2>
    <hr>
    <div class="question_content">
        <table>
            <tr>
                <td><a id="increase_vote"><img src="img/up.png" width="32" height="32"></a></td>
                <td class="content" rowspan="3"><?php echo $row['content'] ?></td>
            </tr>
            <tr>
                <td class="vote"><?php echo $row['vote'] ?></td>
            </tr>
            <tr>
                <td><a id="decrease_vote"><img src="img/down.png" width="32" height="32"></a></td>
            </tr>
        </table>
        <div class="creator">asked by <span class="creator_name"><?php echo $row['name'] ?></span>
            at <?php echo $row['date'] ?> |
            <a href="ask.php?id=<?php echo $row['id'] ?>" class="creator_edit">edit </a> |
            <a href="ask.php?id=<?php echo $row['id'] ?>" class="creator_delete">delete</a>
        </div>
    </div>
</div>

<?php
    $q = "SELECT COUNT(id) AS count from answer where question_id=$id";
    $rq = mysqli_query($db, $q);
    $answer = mysqli_fetch_array($rq, MYSQLI_ASSOC)['count'];
?>
<div class="answer_section">
    <h2><?php echo $answer ?> Answer<?php if ($answer > 1) echo 's' ?></h2>
    <hr>
    <?php
    $q = "SELECT * from answer where question_id=$id";
    if(!$result = $db -> query($q)){
        die('Error Query ['.$db -> error. ']');
    }
    while($row = $result->fetch_assoc()) :
    ?>
    <div class="answer_content">
        <table>
            <tr>
                <td><a id="increase_vote"><img src="img/up.png" width="32" height="32"></a></td>
                <td class="content" rowspan="3"><?php echo $row['content']?></td>
            </tr>
            <tr>
                <td class="vote"><?php echo $row['vote']?></td>
            </tr>
            <tr>
                <td><a id="decrease_vote"><img src="img/down.png" width="32" height="32"></a></td>
            </tr>
        </table>
    </div>
    <div class="creator">answered by <span class="creator_name"><?php echo $row['name']?></span> at <?php echo $row['date']?></div>
    <hr>
    <?php endwhile; ?>
</div>


<div class="answer_box">
    <h2>Your Answer</h2>
    <form action="index.php" method="POST" class="block" name="answerform">
        <input type="text" placeholder="Name" name="name" id="namebox"/>
        <input type="text" placeholder="Email" name="email" id="emailbox" />
        <textarea name="content" placeholder="Content" id="contentbox"></textarea>
        <input type="submit" value="Post" name="Submit" id="submit"/>
        <input type="hidden" name="type" value="answer"  />
        <input type="hidden" name="question_id" value="<?php echo $id ?>"  />
    </form>
</div>
</html>

<?php $db->close(); ?>