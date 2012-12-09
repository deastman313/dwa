<?php

$links = array (
        "Home" => "/index",
        "Dashboard" => "/users/dashboard",
        "Posts" => "/posts/index"
    );

 
$this->template->content->active_link = Router::uri();

$this->template->nav = View::instance('_v_template');

$this->template->nav = $links;

echo $this->template;
?>