<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update user</title>
<link rel="stylesheet" type="text/css" href="styles/styly.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="scripty/dbConn.js" type="text/javascript"></script>
</head>
<body>
<div id="updateDiv">
  <h1>Update user</h1>
  <p>For update double-click on cell</p>
  <form method="post" action="../" id="form_back">
        <input type="hidden" name="name" value="<?= $_REQUEST['name']; ?>"/>
        <input  type="hidden" name="passwd" value="<?= $_REQUEST['passwd']; ?>"/>
        <button type="submit" name="back" id="back"></button>
  </form>
</div>

<div id="update"></div>
<div id="status"></div>


<script type="text/javascript">
	STATUS = 'status';
	getAllUsers( "update" );
</script>
</body>
</html>