<?php
include 'header.php';
 
 
// Destroy the session.
session_destroy();
 
echo("<script>
              location.replace('index.php')
            </script>");
exit;
?>