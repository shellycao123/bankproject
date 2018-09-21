<?php
/**
 * Created by PhpStorm.
 * User: 10563_000
 * Date: 8/20/2018
 * Time: 12:59 AM
 */
function find_all_subjects($options = []){
    //bringing in outside variable into the scope of the function
    global $db;

    $visible = $options['visible']?? false;
    $order = $options['order'] ?? 'position ASC';

    $sql = "SELECT * FROM subjects ";
    if($visible){
        $sql .= "WHERE visible='" . $visible . "' ";
    }
    $sql .= "ORDER BY " . $order . ";";

    $result= mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function find_all_pages($options){
    global $db;

    $visible = $options['visible']?? false;
    $order = $options['order'] ?? 'ASC';

    $sql = "SELECT * FROM pages ";
    if($visible){
        $sql .= "WHERE visible='" . $visible . "' ";
    }
    $sql .= "ORDER BY '" . $order . "';";
    $result= mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function find_subject_by_id($id,$option =[]){
    global $db;

    $visible = $option['visible']?? false;


    $sql = 'SELECT * FROM subjects ';
    $sql .= 'WHERE ' . "id='". db_escape($id) . "'";
    if($visible){
        $sql .= 'AND visible=true'  . ";";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject;
}


function find_page_by_id($id, $option = []){
    global $db;

    $visible = $option['visible']?? false;
    //write the query
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id=" . db_escape($id) . " ";
    if($visible){
        $sql .= 'AND visible=true'  . ";";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $page;

}

function insert_subject($subject){
    global $db;

    $errors = validate_subjects($subject);
    if(!empty($errors)){
        return $errors;
    }

    $sql = 'INSERT INTO subjects(menu_name,visible,position) ';
    $sql .= 'VALUE(' . "'" .db_escape($subject['menu_name']) ."','" . db_escape($subject['visible']) . "','" . db_escape($subject['position']). "');";
    $result = mysqli_query($db,$sql);

    //if the insert was successful
    if($result){
        return true;
    }
    else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_page($page){
    global $db;

    $errors = validate_new_page($page);

    if(!empty($errors)){
        return $errors;
    }
    $sql = "INSERT INTO pages(menu_name, position ,visible,subject_id) ";
    $sql .= "VALUE('" . db_escape($page['menu_name']) . "','" .db_escape($page['position'] ). "','" . db_escape($page['visible']) . "','";
    $sql .= db_escape($page['subject_id']) . "');";
    $result = mysqli_query($db, $sql);

    if($result){
        return true;
    }
    else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}




function edit_subject($subject)
{
    global $db;

    $errors = validate_subjects($subject);
    if(!empty($errors)){
        return $errors;
    }

    $sql = 'UPDATE subjects SET ';
    $sql .= "menu_name='" . db_escape($subject['menu_name']). "', ";
    $sql .= "position='" . db_escape($subject['position']). "', ";
    $sql .= "visible='" . db_escape($subject['visible']). "' ";
    $sql .= "WHERE id='" . db_escape($subject['id']) . "' ";
    $sql .= 'LIMIT 1;';

    $result = mysqli_query($db, $sql);
    if($result){
       return true;
    }
    else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//input is a hash map sent by post method, including the id of the page
function update_page($page){
    global $db;
    $errors = validate_pages($page);

    if(!empty($errors)){
        return $errors;
    }
    $sql = "UPDATE pages SET ";
    $sql .= "menu_name='" . db_escape($page['menu_name']) . "',";
    $sql .= "visible='"  . db_escape($page['visible']) . "',";
    $sql .= "position='" . db_escape($page['position']) . "',";
    $sql .= "subject_id='" . db_escape($page['subject_id']) . "',";
    $sql .= "content='" . db_escape($page['content']) . "' ";
    $sql .= "WHERE id=" . db_escape($page['id'] ). " ";
    $sql .= "LIMIT 1;";

    $result = mysqli_query($db, $sql);
    if(!$result){
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
    else{
        return true;
    }
}

function delete_subject($id){
    global $db;
    $errors = validate_delete_subject_page($id);

    if(!empty($errors)){
        return $errors;
    }

    $sql = 'DELETE FROM subjects ';
    $sql .= "WHERE id='" . db_escape($id) . "' ";
    $sql .= 'LIMIT 1;';
    $result = mysqli_query($db,$sql);

    if($result){
      return true;
    }
    else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_page($id){
    global $db;


    $sql = 'DELETE FROM PAGES ';
    $sql .= "WHERE id='" . db_escape($id) . "' ";
    $sql .= 'LIMIT 1;';

    $result = mysqli_query($db, $sql);

    if($result){
        return true;
    }
    else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function count_page_of_same_subject_id($subject_id){
    global $db;
    $sql = "SELECT COUNT(*) FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($subject_id) . "';";

    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $count =$row[0];
    return $count;
}


function count_all_subjects(){
    global $db;
    $sql = "SELECT COUNT(*) FROM subjects; ";

    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $count =$row[0];
    return $count;
}

function validate_subjects($subject){
    $errors = [];

    //menu name
    if(is_blank($subject['menu_name'])){
        $errors[] = 'Menu name cannot be blank. ';
    }
    if(!has_length($subject['menu_name'], ['min' =>2, 'max' =>255])){
       // echo $subject['menu_name'];
        $errors[] = 'Length of Menu Name must be between 2-255 characters. ';
    }

    //position
    //make sure the value is int
    $int_pos = (int) $subject['position'];
    if($int_pos >999){
        $errors[] = 'Position must be an integer less than 999. ';
    }
    elseif($int_pos < 1){
        $errors[] = 'Position must be an int larger than 0. ';
    }

    //visible
    $str_visible = $subject['visible'];
    if(!has_inclusion_of($str_visible,['0','1'])){
        $errors[] = 'Visibility must be true or false. ';
    }

    return $errors;
}


function validate_pages($page){
    $errors = [];
    //menu_name
    if(is_blank($page['menu_name'])){
        $errors[] = 'Menu Name cannot be empty';
    }
    elseif(!has_length($page['menu_name'],['min' => 2, 'max' => 255])){
        $errors[] = 'Length of Menu name must be 2-255 characters';
    }

    //position
    $pos = (int) $page['position'];
    if($pos >999 || $pos <1){
        $errors[] = 'Position must be an integer in the interval 1-999';
    }

    //visible
    $see = (int) $page['visible'];
    if(!has_inclusion_of($see,[0,1])){
        $errors[] = 'Visibility of the page must be true or false';
    }

    //subject_id

    //content
    if(is_blank($page['content'])){
        $errors[] = 'Content cannot be empty';
    }

    return $errors;
}

function validate_new_page($page){
    $errors = validate_pages($page);
    if(!has_unique_page_menu_name($page['menu_name'])){
        $errors[] = 'Repeated page name';
    }
    return $errors;
}

function validate_delete_subject_page($subject_id){
    $errors = [];
    $count = count_page_of_same_subject_id($subject_id);

    if($count > 0){
        $errors[] = 'Deletion failed. There are still pages belonging to this subject';
    }

    return $errors;
}

function db_escape($string){
    global $db;
    return mysqli_real_escape_string($db, $string);
}

function find_all_pages_by_subject_id($id, $option = []){
    global $db;
    $visible = $option['visible']?? false;
    $order = $option['order']?? 'ASC' ;

    $sql = "SELECT * FROM pages WHERE subject_id = '";
    $sql .= db_escape($id) . "' ";
    if($visible){
        $sql .= "AND visible='" . db_escape($visible) . "' ";
    }
    $sql .= "ORDER BY position ASC;";
    $result = mysqli_query($db , $sql);
    confirm_result_set($result);

    return $result;
}


//admin functions
function get_all_admins(){
    global $db;

    $sql = "SELECT * FROM admins; ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return $result;
}

function insert_admin($admin){
    global $db;
    $errors = validate_admin($admin, ['create_check' => true]);

    if(!empty($errors)){
        return $errors;
    }
$hashed_password = password_hash($admin['hashed_password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO admins(first_name,last_name,username,email,hashed_password) ";
    $sql .= "value('" . db_escape($admin['first_name']) . "','";
    $sql .= db_escape($admin['last_name']) . "','" ;
    $sql .= db_escape($admin['username']) . "','" ;
    $sql .= db_escape($admin['email']) . "','" ;
    $sql .= db_escape($hashed_password) . "');" ;

    $result = mysqli_query($db , $sql);
    if($result){
        return true;
    }
    else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }


}


function validate_admin($admin,$option = []){
    $create_check = $option["create_check"] ?? false;
    $ignore_pw = $option["ignore_pw"] ?? false;
    $error = [];
    //first name and last name
    if(is_blank($admin['first_name'])){
        $error[] = 'First name cannot be empty.';
    }
    elseif(!has_length($admin['first_name'],['min' =>2,'max' => 255])){
        $error[] ="First name must be a string of length 2-255 characters. ";
    }
    if(is_blank($admin['last_name'])){
        $error[] = 'Last name cannot be empty.';
    }

    elseif(!has_length($admin['last_name'],['min' =>2,'max' => 255])){
        $error[] ="Last name must be a non-empty string of length 2-255 characters. ";
    }

    //username
        //length
    if(is_blank($admin['username'])){
        $error[] = 'Username cannot be empty.';
    }
    elseif(!has_length($admin['username'],['min' =>8,'max' => 255])){
        $error[] ="Username must be a string of length 8-255 characters. ";
    }

    //repeat
    $usernames = find_admin_by_username($admin['username']);
    $count = mysqli_num_rows($usernames);
    mysqli_free_result($usernames);
    if($create_check === true){
        if($count!==0){
            $error[] = "Username has already been used.";
        }
    }
    else{
        if($count>1){
            $error[] = "Username has already been used.";
        }
    }



    //email
    if(is_blank($admin['email'])){
        $error[] = 'Email address cannot be empty.';
    }
    elseif(!has_length($admin['email'],['max' => 255])){
        $error[] ="Email address must be less than 255-character long. ";
    }
    elseif(!has_valid_email_format($admin['email'])){
        $error[] = 'Format of the email address is incorrect';
    }

    //password
    if(!$ignore_pw){
        if(!preg_match('/[A-Z]+/',$admin['hashed_password'])){
            $error[] = "Password must include at least one uppercase letter. ";
        }
        if(!preg_match('/[a-z]+/',$admin['hashed_password'])){
            $error[] = "Password must include at least one lowercase letter. ";
        }
        if(!preg_match('/[0-9]+/', $admin['hashed_password'])){
            $error[] = "Password must include at least one number. ";
        }
        if(!preg_match('/[$&+,:;=?@#|\'<>.^*()%!-]+/', $admin['hashed_password'])){
            $error[] = "Password must include at least one special character. ";
        }
        if(!has_length($admin['hashed_password'],['min' => 12])){
            $error[] ="Password must be more than 12-character long. ";
        }

        //confirm the password
        if(is_blank($admin['rep_password'])){
            $error[] = 'Confirm Password cannot be empty.';
        }
        elseif($admin['hashed_password'] !== $admin['rep_password']){
            $error[] = "Password does not match.";
        }
    }


    return $error;


}

function find_admin_by_username($username){
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($username) . "';";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    return $result;
}

function find_admin_by_id($id){
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" .db_escape($id) . "';";
    confirm_result_set($sql);
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);

    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin;
}

function update_admin($admin){
    global $db;

    if(isset($admin['hashed_password']) && is_blank($admin['hashed_password'])){
        $errors = validate_admin($admin,['ignore_pw' => true]);
    }
    else{
        $errors = validate_admin($admin);
    }
    if(!empty($errors)){
        echo display_errors($errors);
        return;
    }
    $hashed_password = password_hash($admin['hashed_password'],PASSWORD_DEFAULT);
    $sql = "UPDATE admins SET first_name='";
    $sql .= db_escape($admin['first_name']) . "',";
    $sql .= "last_name='";
    $sql .= db_escape($admin['last_name']) . "',";
    $sql .= "email='";
    $sql .= db_escape($admin['email']) . "',";
    $sql .= "hashed_password='";
    $sql .= db_escape($hashed_password) . "',";
    $sql .= "username='";
    $sql .= db_escape($admin['username']) . "' ";
    $sql .= "LIMIT 1;";

    $result = mysqli_query($db,$sql);
    if(!$result){
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }

    return $result;

}

function delete_admin($id){
    global $db;

    $sql = "DELETE FROM admins WHERE id='" . db_escape($id) . "' ";
    $sql .= "LIMIT 1;";

    $result = mysqli_query($db,$sql);
    if(!$result){
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
    return $result;
}

//move the position of subjects
function move_subject($old, $new, $id = 0){
    global $db;

    //if it is moving up
    if($old < $new){
        //move old + 1 to new
        $sql = 'UPDATE subjects SET position=position-1 ';
        $sql .= "WHERE position>'" . $old . "' AND position<='" . $new . "' ";
        $sql .= "AND id!='" . $id . "';";
    }

    elseif($old > $new){
        //move new to old-1
        $sql = 'UPDATE subjects SET position=position+1 ';
        $sql .= "WHERE position>='" . $new . "' AND position<'" . $old . "' ";
        $sql .= "AND id!='" . $id . "';";
    }
    //query the db
    $result = mysqli_query($db, $sql);
    if(!$result){
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }

    return true;

}

function move_page($old, $new, $id = 0, $subject_id){
    global $db;

    //if it is moving up
    if($old < $new){
        //move old + 1 to new
        $sql = 'UPDATE pages SET position=position-1 ';
        $sql .= "WHERE position>'" . $old . "' AND position<='" . $new . "' ";
        $sql .= "AND id!='" . $id . "' ";
        $sql .= "AND subject_id='" . db_escape($subject_id) . "';";
    }

    elseif($old > $new){
        //move new to old-1
        $sql = 'UPDATE pages SET position=position+1 ';
        $sql .= "WHERE position>='" . $new . "' AND position<'" . $old . "' ";
        $sql .= "AND id!='" . $id . "';";
        $sql .= "AND subject_id='" . db_escape($subject_id) . "';";

    }
    //query the db
    $result = mysqli_query($db, $sql);
    if(!$result){
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }

    return true;

}


