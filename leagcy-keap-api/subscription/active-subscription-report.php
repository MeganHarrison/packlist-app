<!DOCTYPE html>
<html lang="en">
<head>
  <title>Active Subscription Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Active Subscription Report</h2>
	<p>Unauthorized access is prohibited.</p>
  <form action="active-subscription-results.php" method="POST" role="form">
    <div class="form-group" style="max-width: 350px;">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="auth" name="auth" placeholder="Enter password">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>