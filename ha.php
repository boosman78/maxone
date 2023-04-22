<?php

$ch = "maxsource"; /*معرف قناتك بدون @*/
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$message_id =$message->message_id;
$text = $message->text;
$txt = $message->text;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id3 = $update->callback_query->message->message_id;
preg_match('/أحاديث: (.*)/',$text,$match);
$get1 = json_decode(file_get_contents("hadith.json"));
$get = $get1->$chat_id2;

$data = $update->callback_query->data;
if($data){
$gete = json_decode(file_get_contents("https://dorar.net/dorar_api.json?skey=$get"));
}else{
$gete = json_decode(file_get_contents("https://dorar.net/dorar_api.json?skey=".$match[1]));
}
$gete = $gete->ahadith->result;
$gete = filter_var($gete,FILTER_SANITIZE_STRING);
$gete = explode("--------------",$gete);
$count = count($gete)-1;
if($data){
$gete = str_replace($get,"#$get",$gete);
}else{
$gete = str_replace($text,"#$text",$gete);
}

$gete = str_replace("المزيد","",$gete);





if(preg_match('/أحاديث: (.*)/',$text,$match)){
$dat = json_decode(file_get_contents("hadith.json"),true);
$dat ["$chat_id"] =$match[1];
file_put_contents("hadith.json",json_encode($dat));
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تم العثور على $count من النتائج.. √",
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[0],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[1],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[2],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[3],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[4],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[5],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[6],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[7],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[8],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[9],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[10],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[11],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[12],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[13],
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$gete[14],
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'المطور','url'=>"https://t.me/$ch"]],
]
])
]);
}
