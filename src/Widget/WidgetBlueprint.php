<?php

namespace DashboardPlugin\Widget;

class WidgetBlueprint implements WidgetBlueprintInterface {

  protected $name;
  protected $description;
  protected $url;

  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  public function getName() {
    return $this->name;
  }

  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setUrl($url) {
    $this->url = $url;
    return $this;
  }

  public function getUrl() {
    return $this->url;
  }

}
