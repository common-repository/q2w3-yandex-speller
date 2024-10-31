<div class="wrap">
<h2>Q2W3 Yandex Speller</h2>

<form method="post" action="options.php">

<?php 
settings_fields(self::ID);

if (self::$options['post_langs']['russian']) $plr = 'checked="checked"'; else $plr = false;

if (self::$options['post_langs']['ukrainian']) $plu = 'checked="checked"'; else $plu = false;

if (self::$options['post_langs']['english']) $ple = 'checked="checked"'; else $ple = false;

if (self::$options['enable_comment_spelling']) $ecs = 'checked="checked"'; else $ecs = false;

if (self::$options['comment_langs']['russian']) $clr = 'checked="checked"'; else $clr = false;

if (self::$options['comment_langs']['ukrainian']) $clu = 'checked="checked"'; else $clu = false;

if (self::$options['comment_langs']['english']) $cle = 'checked="checked"'; else $cle = false;
?>

<table class="form-table">

<tr valign="top">
<th scope="row">Поддерживаемые языки для редактора постов:</th>
<td><input type="checkbox" name="<?php echo self::ID.'[post_langs][russian]'?>" <?php echo $plr?> disabled="disabled" />
<input type="hidden" name="<?php echo self::ID.'[post_langs][russian]'?>" value="1" /> Русский<br/>
<input type="checkbox" name="<?php echo self::ID.'[post_langs][ukrainian]'?>" <?php echo $plu?> /> Украинский<br/>
<input type="checkbox" name="<?php echo self::ID.'[post_langs][english]'?>" <?php echo $ple?> /> Английский</td>
</tr>

<tr valign="top">
<th scope="row">Включить TinyMCE для комментариев: </th>
<td><input type="checkbox" name="<?php echo self::ID.'[enable_comment_spelling]'?>" <?php echo $ecs?> /><small> Внимание! Некоторые темы могут не поддерживать эту функцию.</small></td>
</tr>

<tr valign="top">
<th scope="row">Кнопки редактора комментариев: </th>
<td><input type="text" name="<?php echo self::ID.'[comment_editor_buttons]'?>" value="<?php echo self::$options['comment_editor_buttons']?>" style="width: 400px"/></td>
</tr>

<tr valign="top">
<th scope="row">Поддерживаемые языки:</th>
<td><input type="checkbox" name="<?php echo self::ID.'[comment_langs][russian]'?>" <?php echo $clr?> disabled="disabled" />
<input type="hidden" name="<?php echo self::ID.'[comment_langs][russian]'?>" value="1" /> Русский<br/>
<input type="checkbox" name="<?php echo self::ID.'[comment_langs][ukrainian]'?>" <?php echo $clu?> /> Украинский<br/>
<input type="checkbox" name="<?php echo self::ID.'[comment_langs][english]'?>" <?php echo $cle?> /> Английский</td>
</tr>

</table>

<p class="submit">
<input type="submit" class="button-primary" value="Сохранить изменения" />
</p>

</form>

<blockquote>Чтобы восстановить параметры по умолчанию, деактивируйте плагин, а затем снова активируйте его.</blockquote>

</div>