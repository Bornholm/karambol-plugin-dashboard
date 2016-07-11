<?php

namespace DashboardPlugin\Widget;

interface WidgetInterface {

  public function getLabel();
  public function getOrder();
  public function getRow();
  public function getColumnWidth();
  public function getHeight();
  public function getUrl();
  public function getOptions();

}
