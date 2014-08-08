<style type="text/css">
	.ad_descs {max-width:440px}
	.ad_descs img{max-width:100%;max-height:100%}
</style>
<h1>Система управления рекламными материалами</h1>
&nbsp; {U_LIST} &#0183; {U_ADD}
</br></br>

<!-- IF LIST_ADS -->
<table class="forumline">
	<tr>
		<th colspan="6">Управление</th>
	</tr>
	<tr class="row3 med tCenter">
		<td>id</td>
		<td>Вкл</td>
		<td>Описание</td>
		<td>Начало показа</td>
		<td>Конец показа</td>
		<td>Действие</td>
	</tr>
	<!-- BEGIN adsrow -->
	<tr class="{adsrow.ROW_CLASS}" align="center">
		<td>{adsrow.AD_ID}</td>
		<td id="ads_status_{adsrow.AD_ID}">{adsrow.AD_STATUS}</td>
		<td class="list vTop ad_descs"><div class="floatL med">{adsrow.AD_DESC}</div><div class="floatR med">{AD_BLOCK_{adsrow.AD_BLOCK_IDS}}</div>
			<br/><div align="center" style="padding:4px 0">
				{adsrow.AD_HTML}
			</div></td>
		<td class="list">{adsrow.AD_START_TIME}</td>
		<td class="list">{adsrow.AD_FINISH_TIME}</td>
		<td class="list">
			<a href="admin_ads.php?mode=edit&id={adsrow.AD_ID}"><img src="../images/icon_edit.gif" alt="[Del]" title="{L_EDIT}" /></a>
			<a href="admin_ads.php?mode=del&id={adsrow.AD_ID}" onclick="return confirm('{L_ADS_DELETE}');"><img src="../images/icon_delete.gif" alt="[Del]" title="{L_DELETE}" /></a></td>
	</tr>
	<!-- END adsrow -->
	<tr>
		<td class="catBottom" colspan="6">&nbsp;</td>
	</tr>
</table>
<br>
<script type="text/javascript">
	// Delete bonus
	ajax.ads_status = function(a_id) {
		ajax.exec({
			action   : 'ads_status',
			a_id     : a_id
		});
	};
	ajax.callback.ads_status = function(data) {
		var id = data.id
		$('#ads_status_'+id).html(data.html);
	};
</script>
<!-- ENDIF / LIST_ADS -->

<!-- IF ADD_ADS -->
<form method="post">
	<table class="bordered" width="100%">
		<col class="row1">
		<col class="row2">
		<tbody class="pad_4">
		<tr>
			<th colspan="2" class="thHead"><b>Добавление нового баннера</b></th>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Блок</b></td>
			<td class="row2">
				{AD_ID}&nbsp;новые блоки указать в файле config.php
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Дата начала:</b></td>
			<td class="row2">
				<input type="datetime-local" name="ad_start_time" value="{AD_START_TIME}">
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Дата окончания:</b></td>
			<td class="row2">
				<input type="datetime-local" name="ad_finish_time" value="{AD_FINISH_TIME}">
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Активен:</b></td>
			<td class="row2">
				<label><input class="editable-value" type="radio" name="ad_status" value="1" checked="checked"/>{L_YES}</label>
				<label><input class="editable-value" type="radio" name="ad_status" value="0" />{L_NO}</label>&nbsp;
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Краткое описание:</b></td>
			<td class="row2">
				<input type="text" name="ad_desc" style="width:400px;">&nbsp;
			</td>
		</tr>
		</tbody>
		<tr>
			<td class="vTop pad_4" align="right"><b>Код материала:</b></td>
			<td class="vTop pad_0 w100"><textarea name="ad_html" class="editor mrg_4" rows="16" cols="92"></textarea> </td>
		</tr>
		<tr>
			<td class="catBottom" colspan="2"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
		</tr>
	</table>
</form>
<!-- ENDIF / ADD_ADS -->

<!-- IF EDIT_ADS -->
<form method="post">
	<table class="bordered" width="100%">
		<col class="row1">
		<col class="row2">
		<tbody class="pad_4">
		<tr>
			<th colspan="2" class="thHead"><b>Редактирование баннера</b></th>
		</tr>
		<tr>
			<td class="row1" align="right"><b>ID блока</b></td>
			<td class="row2">
				<input type="text" name="ad_block_ids" style="width:150px;" value="{AD_BLOCK_IDS}">&nbsp;
				если несколько, то через запятую
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Дата начала:</b></td>
			<td class="row2">
				<input type="datetime-local" name="ad_start_time" value="{AD_START_TIME}">
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Дата окончания:</b></td>
			<td class="row2">
				<input type="datetime-local" name="ad_finish_time" value="{AD_FINISH_TIME}">
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Активен:</b></td>
			<td class="row2">
				<label><input class="editable-value" type="radio" name="ad_status" value="1" <!-- IF AD_STATUS -->checked="checked"<!-- ENDIF -->/>{L_YES}</label>
				<label><input class="editable-value" type="radio" name="ad_status" value="0" <!-- IF not AD_STATUS -->checked="checked"<!-- ENDIF -->/>{L_NO}</label>&nbsp;
			</td>
		</tr>
		<tr>
			<td class="row1" align="right"><b>Краткое описание:</b></td>
			<td class="row2">
				<input type="text" name="ad_desc" style="width:400px;" value="{AD_DESC}">&nbsp;
			</td>
		</tr>
		</tbody>
		<tr>
			<td class="vTop pad_4" align="right"><b>Код материала:</b></td>
			<td class="vTop pad_0 w100"><textarea name="ad_html" class="editor mrg_4" rows="16" cols="92">{AD_HTML}</textarea> </td>
		</tr>
		<tr>
			<td class="catBottom" colspan="2"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
		</tr>
	</table>
</form>
<!--========================================================================-->
<!-- ENDIF / EDIT_ADS -->