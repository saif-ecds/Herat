<?php session_start();

$_SESSION['email'] = $_REQUEST['email'];
$_SESSION['password'] = $_REQUEST['password'];


if(!empty($_SESSION['email']) ){
	panRedirect('http://'.$_SERVER['HTTP_HOST'].'/createorder.php');
}
else {
	panRedirect("Location: http://".$_SERVER['HTTP_HOST']."/index.php?error=1");
}


function panRedirect( $url, $msg='' ) {
if (headers_sent()) {
echo "<script>document.location.href='$url';</script>\n";
} else {
@ob_end_clean(); // clear output buffer
header( 'HTTP/1.1 301 Moved Permanently' );
header( "Location: ". $url );
}
exit();
}
?>

