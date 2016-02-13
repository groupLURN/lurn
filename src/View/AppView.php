<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
    }

    private function dataTableGetButton($title, $url, $options, $icon)
    {
        $url = $this->Url->build($url);
        $options = [
            'form' => [
                'style' => 'display: initial;'
            ],
            'onclick' => h('window.location = "' . $url . '"')
        ] + $options;

        $title = $icon . ' ' . $title;

        return $this->Form->button($title, $options);
    }

    public function newButton($title, $url)
    {
        $options['class'] = 'btn btn-theme';
        $icon = '<i class="fa fa-plus"></i>';
        return $this->dataTableGetButton($title, $url, $options, $icon);
    }

    public function dataTableViewButton($title, $url)
    {
        $options['class'] = 'btn btn-info btn-xs';
        $icon = '<i class="fa fa-bars"></i>';
        return $this->dataTableGetButton($title, $url, $options, $icon);
    }

    public function dataTableEditButton($title, $url)
    {
        $options['class'] = 'btn btn-primary btn-xs';
        $icon = '<i class="fa fa-pencil"></i>';
        return $this->dataTableGetButton($title, $url, $options, $icon);
    }

    public function dataTableDeleteButton($title, $url, $confirm)
    {
        $options = [
            'class' => 'btn btn-danger btn-xs',
            'form' => [
                'style' => 'display: initial;'
            ],
            'confirm' => $confirm,
            'onclick' => h("if(confirm($(this).attr(\"confirm\"))) $(this).closest(\"form\").submit();")
        ];

        $title = '<i class="fa fa-trash-o"></i> ' . $title;

        $html = $this->Form->create(false, ['url' => $url, 'style' => 'display:initial']);
        $html .= $this->Form->button($title, $options);
        $html .= $this->Form->end();
        return $html;
    }

}
