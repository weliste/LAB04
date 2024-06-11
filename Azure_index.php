<?
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $file = '/tmp/sample-app.log';
  $message = file_get_contents('php://input');
  file_put_contents($file, date('Y-m-d H:i:s') . " Received message: " . $message . "\n", FILE_APPEND);
}
else
{
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>PHP Application - BallotOnline POC</title>
    <meta name="viewport" content="width=device-width">

</head>
<body>
    <section class="congratulations">
        <h1>Congratulations!</h1>
        <p>Your BallotOnline POC PHP Web application is now running in your own dedicated environment in Microsoft Azure App Service!</p>
        <p>You are running PHP version <?= phpversion() ?></p>
    </section>
</body>
</html>
<? 
} 
?>
