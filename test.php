<?php 

$options = [
	'options' => [
		'min_range' => 1,
		'max_range' => 3
	]
];

$list_test = array(
	1 => array('title' => 'Тест по истории', 'file' => "1.json"),
	2 => array('title' => 'Тест по географии', 'file' => "2.json"),
	3 => array('title' => 'Тест по математике', 'file' => "3.json"),
);  

//print("<html><header></header><body>");

if (isset( $_GET['test'] ) AND empty($_POST) AND filter_var($_GET['test'], FILTER_VALIDATE_INT, $options)) {

	$json = json_decode(file_get_contents($list_test[$_GET['test']]['file']), true);

	if (count($json) > 0) {

		print('<form enctype="multipart/form-data" action="test.php?test=' . $_GET['test'] . '" method="post">');

		print('<fieldset>');
		print('<legend>Ваше имя:</legend>');
		print('<label><input type="text" name="user_name"></label>');
		print('</fieldset>');


		foreach ($json as $key => $value) {

			print('<fieldset>');
			print('<legend>' . $value['title'] . '</legend>');

			foreach ($value['ask'] as $keys => $values) {

				//var_dump($values);

				print('<label><input type="radio" name="' . $key . '" value="' . $keys . '"> ' . $keys . '</label>');

			}

			print('</fieldset>');

		}

		print('<input type="submit" value="Отправить">');
		print('</form>');

	}

} else if (!empty($_POST) AND isset( $_GET['test'] ) AND filter_var($_GET['test'], FILTER_VALIDATE_INT, $options)) {

	$json = json_decode(file_get_contents($list_test[$_GET['test']]['file']), true);
	$wrong = 0;

	if (count($json) > 0) {

		//print('<form enctype="multipart/form-data" action="test.php?test=' . $_GET['test'] . '" method="post">');

		foreach ($json as $key => $value) {

			//print('<fieldset>');
			//print('<legend>' . $value['title'] . ' (ответ ' . $_POST[$key] . ')</legend>');

			if ( $value['ask'][$_POST[$key]] == true ) {

				//print("Ответ дан верно!");

			} else {

				//print("Ответ дан не верно!");
				$wrong++;
			}

			//print('</fieldset>');

		}
		//print('</form>');

		header("Content-type: image/png");
		
		$im = imagecreatetruecolor(500, 150);
		$orange = imagecolorallocate($im, 255, 255, 255);
		
		$string = $_POST['user_name'];
		$px = (imagesx($im) - 7.5 * strlen($string)) / 2;
		imagestring($im, 11, $px, 25, $string, $orange);

		$string = "Your rating: " . (count($json) - $wrong) . " / " . count($json);
		$px = (imagesx($im) - 7.5 * strlen($string)) / 2;
		imagestring($im, 11, $px, 80, $string, $orange);

		imagepng($im);
		imagedestroy($im);

	}

} else {

	http_response_code(404);
	echo 'Cтраница не найдена!';
	
}

//print("</body></html>");

exit(1);
?>