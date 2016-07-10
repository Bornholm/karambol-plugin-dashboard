<?php

namespace DashboardPlugin\Widget;

interface WidgetInterface {

  public function getName();
  public function getColumn();
  public function getRow();
  public function getWidth();
  public function getUrl();
  public function getOptions();

}
