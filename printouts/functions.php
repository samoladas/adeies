<?php
function list_leavetypes($pdo)
{
    //fetch user data from the database
    $sql = "SELECT * FROM leavetypes";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $rows = $statement->fetchAll();
    
    $types = array();
    foreach ($rows as $row) {
        //echo $row[0].' -> '.$row[1].'<br>';
        $types[$row[0]] = $row[1];
    }

    return $types;

}

function return_dept($dept, $pdo) 
{
    $sql = "SELECT deptname FROM departments WHERE iddept=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$dept]);
    $row = $statement->fetch();

    return $row['deptname'];
}

function return_supervisor($dept, $pdo)
{
    $sql = "SELECT supervisor FROM departments WHERE iddept=?";
    $statement = $pdo->prepare($sql);
    $statement ->execute([$dept]);
    $row = $statement->fetch();

    return $row['supervisor'];
}

function return_leavedesc($id, $pdo)
{
    $sql = "SELECT leavetype FROM leavetypes WHERE idleavetypes = ?";
    $statement = $pdo -> prepare($sql);
    $statement -> execute([$id]);
    $row = $statement -> fetch();

    return $row['leavetype'];
}

function yesno($i)
{
    if ($i == 0) {
        return 'ΟΧΙ';
    } else {
        return 'ΝΑΙ';
    }
}
?>