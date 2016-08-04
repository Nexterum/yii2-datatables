<?php
/**
 * @copyright Copyright (c) 2014 Serhiy Vinichuk
 * @license MIT
 * @author Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 */

namespace nullref\datatable;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class LinkColumn extends \yii\base\Object
{
    public $queryParams = [];
    public $url;
    public $label;
    public $options = [];
    public $data = null;
    public $render;
    public $searchable;
    public $orderable;
    public $links = [];

    public function init()
    {
        $this->searchable = false;
        $this->orderable = false;
        if(!empty($links)) {
            foreach ($links as $link) {
                if (empty($link->options['id'])) {
                    $link->options['id'] = 'link';
                }
                if (!isset($this->render)) {
                    $this->render = new JsExpression('function render( data, type, row, meta ){
            var p = ' . Json::encode($this->queryParams) . ';
            var q = {};for (var i = 0; i < p.length; i++) {q[p[i]] = row[p[i]];}
            var link = jQuery(\'' . Html::a($link->label, $link->url, $link->options) . '\');
            var paramPrefix = ((link.attr("href").indexOf("?") < 0) ? "?" : "&");
            link.attr("id", link.attr("id") + meta.row);link.attr("href", link.attr("href") + paramPrefix + jQuery.param(q));
            return link.get()[0].outerHTML;}');
                }
            }
        } else {
            if (empty($this->options['id'])) {
                $this->options['id'] = 'link';
            }

            if (!isset($this->render)) {
                $this->render = new JsExpression('function render( data, type, row, meta ){
            var p = ' . Json::encode($this->queryParams) . ';
            var q = {};for (var i = 0; i < p.length; i++) {q[p[i]] = row[p[i]];}
            var link = jQuery(\'' . Html::a($this->label, $this->url, $this->options) . '\');
            var paramPrefix = ((link.attr("href").indexOf("?") < 0) ? "?" : "&");
            link.attr("id", link.attr("id") + meta.row);link.attr("href", link.attr("href") + paramPrefix + jQuery.param(q));
            return link.get()[0].outerHTML;}');
            }
        }


    }


} 