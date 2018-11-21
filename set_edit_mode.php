<?php

	if (isset($_POST['EM_true']))  { 
        setcookie("edit_mode", 'true', time()+3600, "/","", 0);
        // refresh current page
        header('Location: ' . $_SERVER['REQUEST_URI']);
        print ("<script>alert('Warning: you are now in Edit Mode!');</script>");
        exit;
    } 
    elseif (isset($_POST['EM_false'])) {
        setcookie("edit_mode", 'false', time()+3600, "/","", 0);
        // refresh current page
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
?>
