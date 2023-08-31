<?php
    $query = mysql_query("select * from data where id_user = '$id_user' order by date asc");
    $i = 0;
    $options = array();
    while($data = mysql_fetch_array($query)){
       $options[$data['id']] =  $data['name'];
    }
    echo json_encode($options);
?>
