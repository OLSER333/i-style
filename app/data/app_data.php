<?php

$app->salons = $app->db->select("SELECT * FROM `user` WHERE user_status = 'active' AND user_role = 'salon' ORDER BY `user_rating` DESC");
$app->masters = $app->db->select("SELECT * FROM `user` WHERE user_status = 'active' and user_role = 'master' ORDER BY `user_rating` DESC");
