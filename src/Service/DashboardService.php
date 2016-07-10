<?php

namespace DashboardPlugin\Service;

use Karambol\VirtualSet\VirtualSet;

class DashboardService {

  protected $blueprints;
  protected $widgets;

  public function __construct() {
    $this->blueprints = new VirtualSet();
    $this->widgets = new VirtualSet();
  }

  public function getWidgets() {
    return $this->widgets;
  }

  public function getBlueprints() {
    return $this->blueprints;
  }

}
