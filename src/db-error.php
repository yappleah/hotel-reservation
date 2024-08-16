<?php

  header('HTTP/1.1 503 Service Temporarily Unavailable');
  header('Status: 503 Service Temporarily Unavailable');
  header('Retry-After: 600');

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Database Error</title>
<style>
body { padding: 20px; font-size: 60px; }
</style>
</head>
<body>
  Sorry there was a problem completing booking. Please try again later.
</body>
</html>