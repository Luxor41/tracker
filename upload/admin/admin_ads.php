<?php

if (!empty($setmodules)) {
	if (IS_SUPER_ADMIN) $module['TP']['Управление рекламой'] = basename(__FILE__).'?mode=list';
	return;
}
require('./pagestart.php');

$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
$i = 0;

$template->assign_vars(array(
	'U_LIST' => '<a href="admin_ads.php?mode=list" />Список</a>',
	'U_ADD' => '<a href="admin_ads.php?mode=add" />Добавить</a>',
));

switch ($mode)
{
	case 'list':
		$template->assign_vars(array(
			'LIST_ADS'     => true,
			'EDIT_ADS'     => false,
			'S_ADD_ACTION' => 'admin_ads.php?mode=list',
			'ADD_ADS'      => false,
			'DEL_ADS'      => false
		));
		$ads_data = DB()->sql_query("SELECT * FROM bb_ads ORDER BY ad_block_ids");
		while ($data = DB()->sql_fetchrow($ads_data))
		{
			$i++;
			$template->assign_block_vars('adsrow', array(
				'ROW_CLASS'      =>  !($i % 2) ? 'row4' : 'row2',
				'AD_ID'          =>  $data['ad_id'],
				'AD_BLOCK_IDS'   =>  $data['ad_block_ids'],
				'AD_START_TIME'  =>  $data['ad_start_time'],
				'AD_FINISH_TIME' =>  $data['ad_finish_time'],
				'AD_STATUS'      =>  $data['ad_status'] ? '<img class="clickable" src="../images/icon_run.gif" onclick="ajax.ads_status('.$data['ad_id'].'); return false" />' : '<img class="clickable" src="../images/icon_delete.gif" onclick="ajax.ads_status('.$data['ad_id'].'); return false" />',
				'AD_DESC'        =>  $data['ad_desc'],
				'AD_HTML'        =>  $data['ad_html'],
			));
		}
		break;

	case 'add':
		$template->assign_vars(array(
			'LIST_ADS' => false,
			'EDIT_ADS' => false,
			'ADD_ADS'  => true,
			'S_LIST_ACTION'    => 'admin_ads.php?mode=list',
			'DEL_ADS'       => false
		));

		$submit = isset($_POST['submit']);
		if ($submit) // Отправили
		{
# Данные из форм

			$ad_block_ids   = isset($_POST['ad_block_ids']) ? $_POST['ad_block_ids'] : '';
			$ad_start_time  = isset($_POST['ad_start_time']) ? $_POST['ad_start_time'] : '';
			$ad_finish_time = isset($_POST['ad_finish_time']) ? $_POST['ad_finish_time'] : '';
//    $ad_status      = isset($_POST['ad_status']) ? 1 : 0;
			$ad_status      = isset($_POST['ad_status']) ?  $_POST['ad_status'] : 0;
			$ad_desc        = isset($_POST['ad_desc']) ? $_POST['ad_desc'] : '';
			$ad_html        = isset($_POST['ad_html']) ? $_POST['ad_html'] : '';

# Проверим на заполнение полей...
			if ($ad_block_ids == '') {
				$err_mess = 'ID Блоков не указаны! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}
			if ($ad_start_time == '') {
				$err_mess = 'Время начала показа рекламного материала не указано! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}
			if ($ad_finish_time == '') {
				$err_mess = 'Время завершения показа рекламного материала не указано! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}
			if ($ad_desc == '') {
				$err_mess = 'Описание рекламного материала не указано! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}

# Чистим строки
			$ad_block_ids   = DB()->escape($ad_block_ids);
			$ad_start_time  = DB()->escape($ad_start_time);
			$ad_desc        = DB()->escape($ad_desc);
			$ad_html        = DB()->escape($ad_html);
			$max_id         = DB()->sql_query("SELECT MAX(ad_id) as id FROM bb_ads");
			while ($max = DB()->sql_fetchrow($max_id))
			{
				$maxid = $max['id'];
			}
			DB()->query("INSERT bb_ads SET
              ad_id = $maxid+1, ad_block_ids = '$ad_block_ids',
              ad_start_time = '$ad_start_time', ad_finish_time = '$ad_finish_time',
              ad_status = $ad_status, ad_desc = '$ad_desc',
              ad_html = '$ad_html'
            ");
			$message = 'Рекламный материал успешно добавлен. </br> </br> <a href="admin_ads.php?mode=list" />Перейти к списку материалов</a>.';
			bb_die($message);
		}
		break;

	case 'edit':
		$template->assign_vars(array(
			'LIST_ADS'      => false,
			'S_ADD_ACTION'  => 'admin_ads.php?mode=list',
			'ADD_ADS'       => false,
			'EDIT_ADS'      => true,
			'DEL_ADS'       => false
		));
		$id = isset($_GET['id']) ? (int) $_GET['id'] : '';
		if (!$id) {
			$err_mess = 'ID Рекламного материала не указан! <a href="javascript:history.go(-1)" />назад</a>.';
			bb_die($err_mess);
		}

		$ads_data = DB()->sql_query("SELECT * FROM bb_ads WHERE ad_id = $id");
		while ($data = DB()->sql_fetchrow($ads_data))
		{
			$template->assign_vars(array(
				'AD_BLOCK_IDS'   =>  $data['ad_block_ids'],
				'AD_START_TIME'  =>  $data['ad_start_time'],
				'AD_FINISH_TIME' =>  $data['ad_finish_time'],
				'AD_STATUS'      =>  $data['ad_status'],
				'AD_DESC'        =>  $data['ad_desc'],
				'AD_HTML'        =>  $data['ad_html'],
			));
		}
		$submit = isset($_POST['submit']);
		if ($submit) // отправили
		{
			$ad_block_ids   = isset($_POST['ad_block_ids']) ? $_POST['ad_block_ids'] : '';
			$ad_start_time  = isset($_POST['ad_start_time']) ? $_POST['ad_start_time'] : '';
			$ad_finish_time = isset($_POST['ad_finish_time']) ? $_POST['ad_finish_time'] : '';
			$ad_status      = isset($_POST['ad_status']) ? $_POST['ad_status'] : 0;
			$ad_desc        = isset($_POST['ad_desc']) ? $_POST['ad_desc'] : '';
			$ad_html        = isset($_POST['ad_html']) ? $_POST['ad_html'] : '';

			if ($ad_block_ids == '') {
				$err_mess = 'ID Блоков не указаны! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}
			if ($ad_start_time == '') {
				$err_mess = 'Время начала показа рекламного материала не указано! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}
			if ($ad_finish_time == '') {
				$err_mess = 'Время конца показа рекламного материала не указано! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}
			if ($ad_desc == '') {
				$err_mess = 'Описание рекламного материала не указано! <a href="javascript:history.go(-1)" />Вернитесь назад</a> и повторите ввод.';
				bb_die($err_mess);
			}

			$ad_block_ids   = DB()->escape($ad_block_ids);
			$ad_start_time  = DB()->escape($ad_start_time);
			$ad_desc        = DB()->escape($ad_desc);
			$ad_html        = DB()->escape($ad_html);
			$max_id         = DB()->sql_query("SELECT MAX(ad_id) as id FROM bb_ads");
			while ($max = DB()->sql_fetchrow($max_id))
			{
				$maxid = $max['id'];
			}
			DB()->query("UPDATE bb_ads SET
              ad_id = $maxid+1, ad_block_ids = '$ad_block_ids',
              ad_start_time = '$ad_start_time', ad_finish_time = '$ad_finish_time',
              ad_status = $ad_status, ad_desc = '$ad_desc',
              ad_html = '$ad_html'
              WHERE ad_id = $id
            ");
			$message = 'Рекламный материал успешно изменён. </br> </br><a href="admin_ads.php?mode=list" />Перейти к списку материалов</a>.';
			bb_die($message);
		}
		break;

	case 'del':
		$template->assign_vars(array(
			'LIST_ADS'      => false,
			'S_ADD_ACTION'  =>  'admin_ads.php?mode=list',
			'ADD_ADS'       => false,
			'EDIT_ADS'      => false,
			'DEL_ADS'       => true
		));
		$id = isset($_GET['id']) ? (int) $_GET['id'] : '';
		if (!$id) {
			$err_mess = 'ID Рекламного материала не указан! <a href="javascript:history.go(-1)" />назад</a>.';
			bb_die($err_mess);
		}
		$sql = "DELETE FROM bb_ads WHERE ad_id = $id";
		if(!$result = DB()->sql_query($sql))
		{
			bb_die('Could not delete bonus information');
		}
		$sql = "DELETE FROM bb_ads WHERE ad_id = $id";
		if(!$result = DB()->sql_query($sql))
		{
			bb_die('Could not delete ADS information');
		} else {
			$message = 'Рекламный материал успешно удалён! <a href="javascript:history.go(-1)" />назад</a>.';
			bb_die($message);
		}

		break;
}

print_page('admin_ads.tpl', 'admin');