<?php

/**
 * 评论输入爆炸特效插件 https://github.com/cnguu/Bomb-Typecho-Plugin
 *
 * @package Bomb
 * @author cnguu
 * @version 1.0.0
 * @link https://cnguu.cn
 */
class Bomb_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Bomb_Plugin', 'footer');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $colorful = new Typecho_Widget_Helper_Form_Element_Checkbox(
            'colorful',
            ['true' => _t('颜色效果')],
            ['true'],
            _t('开启颜色效果')
        );
        $form->addInput($colorful);
        $shake = new Typecho_Widget_Helper_Form_Element_Checkbox(
            'shake',
            ['true' => _t('振动效果')],
            ['true'],
            _t('开启振动效果')
        );
        $form->addInput($shake);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     * 输出底部
     *
     * @access public
     * @return void
     */
    public static function footer()
    {
        $colorful = Helper::options()->plugin('Bomb')->colorful;
        $shake = Helper::options()->plugin('Bomb')->shake;
        if ($colorful || $shake) {
            $jsUrl = Helper::options()->pluginUrl . '/Bomb/js/cnguu-bomb.min.js';
            printf("<script type='text/javascript' src='%s'></script>\n", $jsUrl);
            $colorful = $colorful ? $colorful[0] : 'false';
            $shake = $shake ? $shake[0] : 'false';
            echo "<script type='text/javascript'>
                (function() {
                    try {
                        (function(){
                            POWERMODE.colorful = {$colorful};
                            POWERMODE.shake = {$shake};
                            document.body.addEventListener('input', POWERMODE);
                            console.log(\"%c 雨眠\",\"color:#7266ba;font-size:4em;\");
                            console.log(\"%c 时间会随着人的感觉而变长或变短，相对论真是既浪漫，又伤感的东西呢。\",\"color:#ffffff;background-color:#7266ba;padding:10px;border-radius:20px;\");
                            console.log(\"\\n %c Cnguu %c https://cnguu.cn \",\"color:#444;background:#eee;padding:5px 0;\",\"color:#eee;background:#444;padding:5px 0;\");
                        })();
                    } catch (e) {
                        console.log(\"插件出错：请联系 www@cnguu.cn\");
                    }
                })();
                </script>\n";
        }
    }
}
