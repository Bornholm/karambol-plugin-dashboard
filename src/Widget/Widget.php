<?php

namespace DashboardPlugin\Widget;

class Widget implements WidgetInterface {

  protected $name;
  protected $width = 12;
  protected $column = 0;
  protected $row = 0;
  protected $url;
  protected $options = [];

  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  public function getName() {
    return $this->name;
  }

  public function setWidth($width) {
    $this->width = $width;
    return $this;
  }

  public function getWidth() {
    return $this->width;
  }

  public function setRow($row) {
    $this->row = $row;
    return $this;
  }

  public function getRow() {
    return $this->row;
  }

  public function setColumn($column) {
    $this->column = $column;
    return $this;
  }

  public function getColumn() {
    return $this->column;
  }

  public function setUrl($url) {
    $this->url = $url;
    return $this;
  }

  public function getUrl() {
    return $this->url;
  }

  public function setOptions(array $options) {
    $this->options = $options;
    return $this;
  }

  public function getOptions() {
    return $this->options;
  }

}
