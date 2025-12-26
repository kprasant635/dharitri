<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {

    private $id;
    private $key;
    private $content;

    public function __construct($id = null, $key=null, $content=null) {
        $this->id = $id;
        $this->key = $key;
        $this->content = $content;
    }

    public function getId() {
        return $this->id;
    }

    public function getKey() {
        return $this->key;
    }

    public function getContent() {
        return $this->content;
    }

}
