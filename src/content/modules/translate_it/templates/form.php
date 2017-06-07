<?php
$translations = ViewBag::get ( "translations" );
?>
<form
	action="<?php echo ModuleHelper::buildAdminURL($module, "sClass=TranslateIt&sMethod=downloadFile");?>"
	method="post">
	<?php csrf_token_html();?>
	<div class="scroll">
		<table class="tablesorter">
			<thead>
				<th style="width: 30%;"><?php translate("title");?></th>
				<th style="width: 70%;"><?php translate("translation");?></th>
			</thead>
			<tbody>
		<?php foreach($translations as $key=>$value){?>
		<tr>
					<td style="width: 30%"><?php Template::escape($key);?>
		</td>
					<td style="width: 70%;"><input type="text"
						name="<?php Template::escape($key);?>"
						value="<?php Template::escape($value);?>"></td>
				</tr>
		<?php }?>
		</tbody>
		</table>
	</div>
	<div class="row">
		<div class="col-xs-8">
			<div class="row">
				<div class="col-xs-4">
					<strong><?php translate("language_code");?></strong>
				</div>

				<div class="col-xs-8">
					<input type="text" name="language_code" required
						value="<?php Template::escape(getCurrentLanguage());?>">
				</div>
			</div>
		</div>
		<div class="col-xs-4 text-right">
			<input type="submit"
				value="<?php translate("generate_language_file");?>"
		
		</div>
	</div>

</form>