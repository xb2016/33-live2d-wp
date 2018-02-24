<?php
/*
Plugin Name: 33-live2d
Plugin URI: https://github.com/xb2016/33-live2d-wp
Description: 33娘的live2d看板娘插件-WordPress。这里只提供了一套服装，其它的需要你自己想办法～
Author: 小白-白
Version: 1.0
Author URI: https://www.fczbl.vip
*/

define('l2d_URL', plugins_url('', __FILE__));
//SETTINGS
add_action('admin_menu', 'plugin_33_l2d');
function plugin_33_l2d() {
    add_options_page('33live2d', 'L2D看板娘设置', 'manage_options', 'plugin-33', 'plugin_33_option_page');
}
function plugin_33_option($option_name) {
    global $plugin_33_options;
    if (isset($plugin_33_options[$option_name])) {
        return $plugin_33_options[$option_name];
    } else {
        return null;
    }
}
function plugin_33_update_options() {
    update_option('plugin_33_jq', plugin_33_option('jq'));
    update_option('plugin_33_fa', plugin_33_option('fa'));
    }
function plugin_33_option_page() {
    if(!current_user_can('manage_options')) wp_die('抱歉，您没有权限来更改设置');
    if(isset($_POST['update_options'])){
        global $plugin_33_options;
        $plugin_33_options['jq'] = $_POST['jq'];
        $plugin_33_options['fa'] = $_POST['fa'];
        plugin_33_update_options();
        echo '<div id="message" class="updated fade"><p>设置已保存</p></div>';
    } ?>
    <div class="wrap">
        <h2>33娘L2D看板娘设置</h2>
        <form action="options-general.php?page=plugin-33" method="post">
        <?php wp_nonce_field('plugin-33-options'); ?>
            <table class="form-table">
                <tr>
                <td>
                   <h3>加载jQuery库</h3>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_33_jq')); ?>" name="jq" />配置是否加载JQ：1是，0否<br />
                   <h3>加载Font Awesome</h3>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_33_fa')); ?>" name="fa" />配置是否加载FA：1是，0否<br />
                   <br /><p>本插件需要加载jQuery库与Font Awesome支持，如果你的主题没有引用上述项目，请选择加载。</p><br />
                   <p>关于提示语的修改，请直接编辑js/waifu-tips.js。</p><br />
                   <p>需要更多服装/模型，或者需要换装功能，请自行思考解决。</p>
				   </td>
                </tr>
            </table>
            <p class="submit"><input name="update_options" value="保存设置" type="submit" /></p>
        </form>
    </div><?php        
}
//MAIN
add_action('wp_footer','l2d_main');
function l2d_main(){ 
    if(get_option(plugin_33_jq)==1) echo'<script src="'.l2d_URL.'/js/jquery.min.js"></script>';
    echo '
    <div class="waifu">
        <div class="waifu-tips"></div>
        <canvas id="live2d" width="230" height="250" class="live2d"></canvas>
        <div class="waifu-tool">
            <span class="fa fa-home"></span>
            <span class="fa fa-comments"></span>
            <span class="fa fa-camera"></span>
            <span class="fa fa-info-circle"></span>
            <span class="fa fa-close"></span>
        </div>
        <script src="'.l2d_URL.'/js/waifu-tips.js"></script>
        <script src="'.l2d_URL.'/js/live2d.js"></script>
        <script type="text/javascript">loadlive2d("live2d","'.l2d_URL.'/33/33.json");</script>
    </div>
    ';
}
//CSS
add_action('wp_enqueue_scripts','l2d_scripts');
function l2d_scripts(){
    if(get_option(plugin_33_fa)==1) wp_enqueue_style('awesome',l2d_URL.'/css/font-awesome.min.css',array(),'4.7.1');
    wp_enqueue_style('waifu',l2d_URL.'/css/waifu.min.css',array(),'1.0');
    
}