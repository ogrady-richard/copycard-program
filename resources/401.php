<head>
    <title>401 Unauthorized</title>
</head>
<body>
    <h1>Unauthorized</h1>
    <p>You do not have sufficient permissions. Please <a href='index.html'>login</a> and try to access this page again.</p>
    <hr>
    <address><?php echo $_SERVER['SERVER_SOFTWARE']?> at <?php echo $_SERVER['SERVER_NAME']; ?> Port <?php echo $_SERVER['SERVER_PORT']?></address>
</body>