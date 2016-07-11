<?php

namespace DashboardPlugin\Widget;

class Widget implements WidgetInterface {

  protected $label;
  protected $columnWidth = 12;
  protected $height = null;
  protected $order = 0;
  protected $row = 0;
  protected $url;
  protected $options = [];

  public function setLabel($label) {
    $this->label = $label;
    return $this;
  }

  public function getLabel() {
    return $this->label;
  }

  public function setHeight($height) {
    $this->height = $height;
    return $this;
  }

  public function getHeight() {
    return $this->height;
  }

  public function setColumnWidth($columnWidth) {
    $this->columnWidth = $columnWidth;
    return $this;
  }

  public function getColumnWidth() {
    return $this->columnWidth;
  }

  public function setRow($row) {
    $this->row = $row;
    return $this;
  }

  public function getRow() {
    return $this->row;
  }

  public function setOrder($order) {
    $this->order = $order;
    return $this;
  }

  public function getOrder() {
    return $this->order;
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
