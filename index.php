<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Тарифы</title>
</head>
<body>
<?php
$json_url = 'http://sknt.ru/job/frontend/data.json';
$json_string = file_get_contents($json_url); //должен быть включен openssl в настройках php. для windows также нужно раскомментировать extension_dir
if ($json_string) {
	$json_object = json_decode($json_string);
	if ($json_object) {
		if (array_key_exists("result",$json_object) && !strcmp($json_object->result, "ok")) {
			if (array_key_exists("tarifs",$json_object) && count($json_object->tarifs) > 0) {
				foreach ($json_object->tarifs as $key => $plan) {
					echo $plan->title.'<br>';
				}
			} else {
				echo 'Тарифных планов нет';
			}
		} else {
			echo 'JSON result != "ok"';
		}
	} else {
		echo 'Произошла ошибка при обработке данных ('.json_last_error_msg().')';
	}
} else {
	echo 'Произошла ошибка при получении данных о тарифах';
}	
?>
</body>
</html>