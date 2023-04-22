<?php

$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$message_id = $message->message_id;

$json = json_decode(file_get_contents("save.txt"),true);
$getjson = json_decode(file_get_contents("save.txt"));

$user = $getjson->$id;
$save = $user->save;

$sour = array("عودة","الفاتحة","البقرة","ال عمران","النساء","المائدة","الأنعام","الأعراف","الأنفال","التوبة","يونس","هود","يوسف","الرعد","ابراهيم","الحجر","النحل","الإسراء","الكهف","مريم","طه","الأنبياء","الحج","المؤمنون","النور","الفرقان","الشعراء","النمل","القصص","العنكبوت","الروم","لقمان","السجدة","الأحزاب","سبإ","فاطر","يس","الصافات","ص","الزمر","غافر","فصلت","الشورى","الزخرف","الدخان","الجاثية","الأحقاف","محمد","الفتح","الحجرات","ق","الذاريات","الطور","النجم","القمر","الرحمن","الواقعة","الحديد","المجادلة","الحشر","الممتحنة","الصف","الجمعة","المنافقون","التغابن","الطلاق","التحريم","الملك","القلم","الحاقة","المعارج","نوح","الجن","المزمل","المدثر","القيامة","الانسان","المرسلات","النبإ","النازعات","عبس","التكوير","الإنفطار","المطففين","الإنشقاق","البروج","الطارق","الأعلى","الغاشية","الفجر","البلد","الشمس","الليل","الضحى","الشرح","التين","العلق","القدر","البينة","الزلزلة","العاديات","القارعة","التكاثر","العصر","الهمزة","الفيل","قريش","الماعون","الكوثر","الكافرون","النصر","المسد","الإخلاص","الفلق","الناس");

//الباحث النصي
if($text == "الاوامر"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*
🗳 اهلا بك في قائمة الاوامر :
—————*
۝  بحث  ~ للبحث عن اية
۝  الميسر ~ لتفسير اية
۝  الجلالين ~ لتفسير اية
۝  شرح بالإنجليزية ~ لترجمة اية 
۝  بحث صوتي ~ للبحث الصوتي 
۝  عودة ~ للرجوع الى القائمة 
*۝  اللهم صل على محمدا وال محمد 
۝  صفحة + رقم الصفحة لجلبها من القرآن الكريم

**—————*",'parse_mode'=>'markdown'
]);
}
$write = array(
  "بحث",
  "الميسر",
  "الجلالين",
  "شرح بالإنجليزية",
  "عودة",
  );
$writeafter = array(
  "search",
  "tafser2",
  "tafser1",
  "english"
  );
$writemessage = array(
  "حسنا ، أرسل ما تذكره من الاية ليتم البحث عنها",
  "حسنا ، أرسل ما تذكره من الاية ليتم تفسيرها -تفسير الميسر-",
  "حسنا ، أرسل ما تذكره من الاية ليتم تفسيرها -تفسير الجلالين-",
  "حسنا ، أرسل ما تذكره من الاية ليتم شرحها باللغة الإنجليزية",
  );
$writesave = str_replace($write, $writeafter, $text);
$writemessage = str_replace($write, $writemessage, $text);


//الباحث الصوتي

$sound = array(
  "عبد الباسط عبد الصمد",
  "عبد الله المطرود",
  "عبد الرحمن العوسي",
  "أبو بكر الشاطري",
  "أحمد العجمي",
  "فارس عباد",
  "محمود خليل الحصري",
  "ماهر المعيقلي",
  "محمد صديق المنشاوي",
  "عودة",
  );

$soundafter = array(
  "abdul_basit",
  "al_matrood",
  "al_ausi",
  "al_shatri",
  "al_ajmi",
  "abbad",
  "al_husori",
  "al_mueaqly",
  "sddeq",
  );
  
$soundsave = str_replace($sound, $soundafter, $text);

//start
if($text == "/start" or $text == "عودة"){
  $json ["$id"]["save"] = "start";
  file_put_contents("save.txt",json_encode($json));
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"*
🗳 اهلا بك في قائمة الاوامر :
—————*
۝  بحث ~ للبحث عن اية
۝  الميسر ~ لتفسير اية
۝  الجلالين ~ لتفسير اية
۝  شرح بالإنجليزية ~ لترجمة اية 
۝  بحث صوتي ~ للبحث الصوتي 
۝  عودة ~ للرجوع الى القائمة 
*۝  اللهم صل على محمدا وال محمد ♡*
*—————*",'parse_mode'=>'markdown',
    "reply_to_message_id"=>$message_id,
  ]);
  return;
}


if(in_array($text,$write)){
  $json ["$id"]["save"] = "$writesave";
  file_put_contents("save.txt",json_encode($json));
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>$writemessage,
    "reply_to_message_id"=>$message_id,
  ]);
  return;
}

if(in_array($save,$writeafter)){
  $get = json_decode(file_get_contents("https://api-quran.cf/quransql/index.php?text=".urlencode($text)."&type=".$save))->result;
  $count = count($get);
  if($count > 10)
    $l = 10;
  else
    $l = $count;
  for( $i=0; $i <= $l; $i++){
    bot("sendMessage",[
      "chat_id"=>$chat_id,
      "text"=>$get[$i],
'reply_markup'=>json_encode([
'remove_keyboard'=>true
])
    ]);
$json["$id"]["save"] = "done";
  file_put_contents("save.txt",json_encode($json));
  }
}



//أوامر الباحث الصوتي


if($text == "بحث صوتي"){
  foreach($sound as $key){
    $keyboard[] = [$key];
  }
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"
حسنا ، اختر أحد القراء
    ",
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>$keyboard
    ])
  ]);
}
if($text){
if(in_array($text,$sound)){
  $json["$id"]["save"] = "$soundsave";
  file_put_contents("save.txt",json_encode($json));
  foreach($sour as $key){
    $keyboard[] = [$key];
  }
  bot("sendMessage",[
    "chat_id"=>$chat_id,
    "text"=>"تم إختيار القارئ ، قم الان بكتابة اسم السورة أو قم بالإختيار من الكيبورد في الاسفل..",
    "reply_to_message_id"=>$message_id,
    "reply_markup"=>json_encode([
      'keyboard'=>$keyboard
    ])
  ]);
}
}
if($text){
if(in_array($save,$soundafter)){
  $get = json_decode(file_get_contents("https://api-quran.cf/quransql/mp3.php?text=".urlencode($text)."&reader=".$save));
  bot('sendaudio',[
    'chat_id' => $chat_id,
    'audio' => $get->url,
    'caption'=>$get->caption,
    "reply_to_message_id"=>$message_id,
'reply_markup'=>json_encode([
'remove_keyboard'=>true
])
 ]);
  $json["$id"]["save"] = "done";
  file_put_contents("save.txt",json_encode($json));
}
}

 $ex = explode("صفحة ",$text);
if($ex[1] < 10){
bot('sendphoto',[
'chat_id'=>$chat_id,
'photo'=>"https://www.daily-quran.com/static/pages/page-00$ex[1].jpg",
'caption'=>"*- تم العرض  للعرض من داخل الموقع،
- اضغط على الزر من الاسفل  نسألكم الدعاء .
------------*",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>"- الانتقال الى الموقع - ❤",'url'=>"https://www.daily-quran.com/quran/page/$ex[1].jpg"]]]
])
]);
}
if($ex[1] >= 10 and $ex[1] <100){
bot('sendphoto',[
'chat_id'=>$chat_id,
'photo'=>"https://www.daily-quran.com/static/pages/page-0$ex[1].jpg",
'caption'=>"*- تم العرض  للعرض من داخل الموقع،
- اضغط على الزر من الاسفل  نسألكم الدعاء .
------------*",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>"- الانتقال الى الموقع -❤",'url'=>"https://www.daily-quran.com/quran/page/0$ex[1].jpg"]]]
])
]);
}
if($ex[1] >= 100){
bot('sendphoto',[
'chat_id'=>$chat_id,
'photo'=>"https://www.daily-quran.com/static/pages/page-$ex[1].jpg",
'caption'=>"*- تم العرض  للعرض من داخل الموقع،
- اضغط على الزر من الاسفل  نسألكم الدعاء .
------------*",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>"- الانتقال الى الموقع -❤",'url'=>"https://www.daily-quran.com/quran/page/$ex[1].jpg"]]]
])
]);
}