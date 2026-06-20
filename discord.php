<?php
function ok() { $i=imagecreatetruecolor(1,1); imagefill($i,0,0,imagecolorallocate($i,255,0,0)); header('Content-Type: image/jpeg'); imagejpeg($i); imagedestroy($i); }
function err() { header('HTTP/1.1 404 Not Found'); echo '404'; }
$wh = rawurldecode($_GET['webhook']??'');
$msg = $_GET['message']??'';
if ($wh==='' || $msg==='') { err(); exit; }
$payload = json_encode(['content'=>$msg]);
$ctx = stream_context_create(['http'=>['method'=>'POST','header'=>"Content-Type: application/json\r\nContent-Length: ".strlen($payload)."\r\n",'content'=>$payload,'ignore_errors'=>true],'ssl'=>['verify_peer'=>true]]);
file_get_contents($wh, false, $ctx);
$code = 0;
if (isset($http_response_header)) { preg_match('/\d{3}/',$http_response_header[0],$m); $code = (int)($m[0]??0); }
if ($code===204) ok(); else err();