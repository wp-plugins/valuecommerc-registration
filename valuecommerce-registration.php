<?php
/* これは文字化け防止のための日本語文字列です。
   このソースファイルは UTF-8 で保存されています。
   Above is a Japanese strings to avoid charset mis-understanding.
   This source file is saved with UTF-8. */
/*
Plugin Name: Valuecommerce Site Registration
Plugin URI: http://vcsearch.web-service-api.jp/
Description: バリューコマースにサイトを登録する際に必要なタグ埋め込みを行うプラグイン
Author: wackey
Version: 1.00
Author URI: http://musilog.net/
*/

/*  Copyright 2009-2010 wackey

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


// ヘッダにValuecommerce認証用タグを追加する
function add_vc_regist() {
$vctag= get_option('valuecommerce_registration_tag');
echo stripslashes($vctag);
}

// 管理画面の作成

// 管理画面メニュー作成関数
function valuecommerce_registration_menu() {
add_options_page('Valuecommerce registration Options', 'Valuecommerce registration', 8, __FILE__, 'valuecommerce_registration_options');
}


// 管理画面描画
function valuecommerce_registration_options() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('valuecommerce_registration-options');
update_option('valuecommerce_registration_tag', $_POST['valuecommerce_registration_tag']);
//$this->upate_options(); ?>
<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p>
</div> <?php }
$valuecommerce_registration_tag= get_option('valuecommerce_registration_tag');
?>

<div class="wrap">
<h2>Valuecommerce Site Registrationプラグイン管理画面</h2>
<p>バリューコマースのサイトを登録したときの認証用タグを入れてください。<br>
入力後、ブログ表示のソースにタグが埋め込まれているのでURLをバリューコマースの指定された場所に入力してください。</p>
<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('valuecommerce_registration-options'); ?>

<table class="form-table"><tbody>
<tr>
<th><label for="valuecommerce_registration_tag"><?php
_e('バリューコマースサイト認証用タグ', 'valuecommerce_registration'); ?></label></th> <td><input size="36" type="text" name="valuecommerce_registration_tag"
id="valuecommerce_registration_tag" value="<?php
echo attribute_escape($valuecommerce_registration_tag); ?>" /></td>
</tr>
</tbody></table>

<p class="submit">
<input type="submit" name="update_option" class="button- primary" value="<?php _e('Save Changes'); ?>" />
</p>

</form>
</div>

<?php
}


// プラグイン停止時にフィールドを削除
function remove_valuecommerce_registration()
{
	delete_option('valuecommerce_registration_tag');
}


// WordPressプラグインとして登録するもの（ショートコードなど）
// 認証タグヘッダーに挿入
add_action('wp_head','add_vc_regist');

// 管理画面、管理用
add_action('admin_menu', 'valuecommerce_registration_menu');
add_action('deactivate_valuecommerce_registration/valuecommerce_registration.php', 'remove_valuecommerce_registration');


?>