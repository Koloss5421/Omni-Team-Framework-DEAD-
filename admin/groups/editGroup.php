<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location: ../../login.php');
}
?>
<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="../../js/bootstrap.js"></script>
        <script src="../../js/jscolor.js"></script>

        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../../css/custom.css">
        <title>TEST</title>

    </head>

    <body>
        <?php
        $GroupID = "";
        $GroupName = "";
        $GroupDesc = "";


        if (!empty($_REQUEST['chk'])) {
            foreach ($_REQUEST['chk'] as $check) {
                $getGroupID = $check;
                unset($_REQUEST['chk']);
            }
        } else {
            if ($_SERVER['HTTP_REFERER'] == "http://cal.teamexile.net/admin.php?f=groups&p=editGroup" && !$_POST['editGroupForm']) {
                //header('location: admin.php?f=schedule&p=view');
            } else {
                //header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }

        if (isset($getGroupID)) {
            include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

            $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT * FROM groups WHERE group_id='$getGroupID'");
        }
        while ($row = mysqli_fetch_array($result)) {
            $GroupID = $row['group_id'];
            $GroupName = $row['name'];
            $GroupDesc = $row['description'];
            $GroupType = $row['type'];
        }
        ?>
        <div class="container">
            <div class="center-block" style="max-width:700px">
                <h3 class="heading text-center">Edit Group</h3><br />
                <form class="form-horizontal" name="editUserForm" id="editGroupForm" action="admin.php?f=groups&p=save" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="F_GroupID">Group ID: </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="F_GroupID" id="F_GroupID" placeholder="<?php echo $GroupID; ?>" value="<?php echo $GroupID; ?>" readonly>
                        </div>
                        <?php
                        if ($GroupType == 1) {
                            $select = '<label class="col-sm-3 control-label" for="F_Coach">Assign Coach: </label>';
                            $select .= '<div class="col-sm-3">';
                            $select .= '<select class="form-control" name="F_Coach" style="width:150px" id="F_Coach">';
                            $select .= '<option value="" hidden>Select a Coach...</option>';
                            $select .= '<option value="">NONE</option>';

                            $coaches = array();

                            $getAllCoaches = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.group_id = 2");


                            while ($row = mysqli_fetch_assoc($getAllCoaches)) {


                                $coaches[$row['username']] = $row['id'];
                            }

                            $notAssigned = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.coach WHERE usergroups.coach IS NOT NULL");

                            while ($res = mysqli_fetch_assoc($notAssigned)) {

                                if ($res['group_id'] != $GroupID) {
                                    if (array_key_exists($res['username'], $coaches)) {
                                        unset($coaches[$res['username']]);
                                    }
                                } else {
                                    $coachID = $res['id'];
                                }
                            }

                            foreach ($coaches as $key => $value) {


                                if ($value == $coachID) {
                                    $select .= '<option value="' . $value . '" selected>' . $key . '</option>';
                                } else {
                                    $select .= '<option value="' . $value . '">' . $key . '</option>';
                                }
                            }


                            $select .= '</select>';
                            $select .= '</div>';
                        } else {
                            $select = '<div class="col-sm-3"><div class="col-sm-3"></div></div>';
                        }

                        echo $select;

                        //print_r($coaches);
                        ?>


                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="F_GroupName">Group Name: </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="F_GroupName" id="F_GroupName" placeholder="<?php echo $GroupName; ?>" value="<?php echo $GroupName; ?>" required>
                        </div>
                        <label class="col-sm-3 control-label" for="F_GroupType">Group Type: </label>
                        <div class="col-sm-3">

                            <select class="form-control" name="F_GroupType" id="F_GroupType" required>
                                <option value="0" <?php
                                if ($GroupType == "0") {
                                    echo "selected";
                                }
                                ?> >Group</option>
                                <option value="1" <?php
                                if ($GroupType == "1") {
                                    echo "selected";
                                }
                                ?> >Team</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="F_Desc">Group Description: </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="F_Desc" id="F_Desc" placeholder="<?php echo $GroupDesc; ?>" rows="4" maxlength="150" required><?php echo $GroupDesc; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="F_users">Assign Users: </label>
                        <div class="col-sm-3">
                            <label class="control-label" for="F_users">Groupless: </label>
                            <?php
                            $getUsers = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.user_id IS NULL");

                            $select = '<select class="form-control" name="F_users[]" size="8" style="width:150px" id="F_users" multiple="multiple">';

                            while ($rs = mysqli_fetch_assoc($getUsers)) {

                                $select .= '<option value="' . $rs['id'] . '">' . $rs['username'] . '</option>';
                            }

                            $select .= '</select>';
                            echo $select;
                            ?>
                            <input class="btn pull-left" type="button" name="toGroup" id="toGroup" value="+ Group" />
                            <input class="btn pull-right" type="button" name="toUsers" id="toUsers" value="- Group" />

                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="F_group">In Group: </label>
                            <?php
                            $getUsers = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.sub != '1' && usergroups.group_id = $GroupID");

                            $select = '<select class="form-control" name="F_group[]" size="8" style="width:150px" id="F_group" multiple="multiple">';

                            while ($rs = mysqli_fetch_assoc($getUsers)) {

                                $select .= '<option value="' . $rs['id'] . '">' . $rs['username'] . '</option>';
                            }

                            $select .= '</select>';
                            echo $select;
                            ?>
                            <input class="btn pull-left" type="button" name="toSubs" id="toSubs" value="+ Sub" />
                            <input class="btn pull-right" type="button" name="toPlayers" id="toPlayers" value="- Sub" />

                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="F_subs">Subs: </label>
                            <?php
                            $getUsers = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.sub = '1' && usergroups.group_id = $GroupID");

                            $select = '<select class="form-control" name="F_subs[]" size="8" style="width:150px" id="F_subs" multiple="multiple">';

                            while ($rs = mysqli_fetch_assoc($getUsers)) {

                                $select .= '<option value="' . $rs['id'] . '">' . $rs['username'] . '</option>';
                            }

                            $select .= '</select>';
                            echo $select;
                            ?>

                        </div>
                    </div>
                    <div class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-success" name="editGroupFormButton" id="editGroupFormButton" onclick="selectAll()" type="submit" value="addNew"><span class="glyphicon glyphicon-floppy-save"></span> Save Group</button>
                            <button class="btn btn-danger" name="editGroupForm" id="editGroupForm" type="button" onclick="location.href = 'admin.php?f=groups&p=view'"><span class="glyphicon glyphicon-floppy-remove"></span> Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {

                function cutAndPaste(from, to) {
                    $(to).append(function() {
                        return $(from + " option:selected").each(function() {
                            this.outerHTML;
                        }).remove();
                    });
                }

                $("#toGroup").off("click").on("click", function() {
                    cutAndPaste("#F_users", "#F_group");
                });

                $("#toUsers").off("click").on("click", function() {
                    cutAndPaste("#F_group", "#F_users");
                });
                $("#toSubs").off("click").on("click", function() {
                    cutAndPaste("#F_group", "#F_subs");
                });

                $("#toPlayers").off("click").on("click", function() {
                    cutAndPaste("#F_subs", "#F_group");
                });

            });

            function selectAll()
            {
                usersBox = document.getElementById("F_users");

                groupBox = document.getElementById("F_group");

                subsBox = document.getElementById("F_subs");

                for (var i = 0; i < usersBox.options.length; i++)
                {
                    usersBox.options[i].selected = true;
                }

                for (var i = 0; i < groupBox.options.length; i++)
                {
                    groupBox.options[i].selected = true;
                }

                for (var i = 0; i < subsBox.options.length; i++)
                {
                    subsBox.options[i].selected = true;
                }
            }
        </script>
    </body>
</html>