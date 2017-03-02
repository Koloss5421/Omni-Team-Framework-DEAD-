<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('location: ../../login.php');
}

include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

$GroupID = $_REQUEST['F_GroupID'];
$GroupType = $_REQUEST['F_GroupType'];
$NewGroupName = $_REQUEST['F_GroupName'];
$NewGroupDesc = $_REQUEST['F_Desc'];
$NewCoach = $_REQUEST['F_Coach'];
$NewGroup = array();
$NewSubs = array();

echo "Got Variables! <br />";


if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
echo "Connected Successfully! <br />";

if ($_POST['addGroupFormButton']) {

    echo 'inside addGroup IF Statement <br />';

    $query = "INSERT INTO groups (name, type, description) VALUES ('$NewGroupName', '$GroupType', '$NewGroupDesc')";

    if ($conn->query($query) === TRUE) {

        echo "New Record Created! <br />";

        $GetNewID = "SELECT * FROM usergroups WHERE name = $NewGroupName && description = $NewGroupDesc";
        $result = $conn->query($GetNewID);

        while ($row = $result->fetch_assoc()) {

            $NewGroupID = $row['group_id'];
        }

        foreach ($_REQUEST['F_group'] as $member) {


            $addRegMem = "INSERT INTO usergroups (user_id, group_id) VALUES ('$member', '$NewGroupID')";

            if ($conn->query($addRegMem) === TRUE) {

                echo "New Record Created! <br />";
            } else {
                echo "ERROR: <br />" . $addRegMem . "<br>" . $conn->error;
            }
        }

        foreach ($_REQUEST['F_subs'] as $member) {

            $addSubMem = "INSERT INTO usergroups (user_id, group_id, sub) VALUES ('$member', '$NewGroupID', '1')";

            if ($conn->query($addSubMem) === TRUE) {

                echo "New Record Created! <br />";
            } else {
                echo "ERROR: <br />" . $addSubMem . "<br>" . $conn->error;
            }
        }

        $addNewCoach = "INSERT INTO usergroups (group_id, coach) VALUES ('$GroupID', '$NewCoach')";
        if ($conn->query($addNewCoach) === TRUE) {
            echo "New Coach added!";
        }
    } else {
        echo "ERROR: <br />" . $query . "<br>" . $conn->error;
    }
}
if ($_POST['editGroupFormButton']) {
    echo 'inside adduser IF Statement <br />';

    $query = "UPDATE groups SET name='$NewGroupName', type='$GroupType', description='$NewGroupDesc' WHERE group_id='$GroupID'";

    if ($conn->query($query) === TRUE) {

        echo "New Record Created! <br />";

        foreach ($_REQUEST['F_users'] as $member) {

            $Remove = "DELETE FROM usergroups WHERE user_id = $member";

            if ($conn->query($Remove) === TRUE) {

                echo "All Records Removed <br />";
            } else {
                echo "ERROR: <br />" . $Remove . "<br>" . $conn->error;
            }
        }

        foreach ($_REQUEST['F_group'] as $member) {

            $remPrev = "DELETE FROM usergroups WHERE user_id = $member";
            $conn->query($remPrev);

            $addRegMem = "INSERT INTO usergroups (user_id, group_id) VALUES ('$member', '$GroupID')";

            if ($conn->query($addRegMem) === TRUE) {

                echo "New Record Created! <br />";
            } else {
                echo "ERROR: <br />" . $addRegMem . "<br>" . $conn->error;
            }
        }

        foreach ($_REQUEST['F_subs'] as $member) {

            $remPrev = "DELETE FROM usergroups WHERE user_id = $member";
            $conn->query($remPrev);

            $addSubMem = "INSERT INTO usergroups (user_id, group_id, sub) VALUES ('$member', '$GroupID', '1')";

            if ($conn->query($addSubMem) === TRUE) {

                echo "New Record Created! <br />";
            } else {
                echo "ERROR: <br />" . $addSubMem . "<br>" . $conn->error;
            }
        }
    } else {
        echo "ERROR: <br />" . $query . "<br>" . $conn->error;
    }

    $remPrevCoach = "DELETE FROM usergroups WHERE user_id IS NULL && group_id = $GroupID && coach IS NOT NULL";

    if ($conn->query($remPrevCoach) === TRUE) {
        echo "Old Coach Removed";

        $addNewCoach = "INSERT INTO usergroups (group_id, coach) VALUES ('$GroupID', '$NewCoach')";
        if ($conn->query($addNewCoach) === TRUE) {
            echo "New Coach added!";
        }
    }
}
$conn->close();
header("location: admin.php?f=groups&p=view");
?>