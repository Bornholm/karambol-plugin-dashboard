<?php

namespace DashboardPlugin\Controller\Admin;

use Karambol\Controller\AbstractEntityController;
use Symfony\Component\Form\Extension\Core\Type as Type;
use DashboardPlugin\DashboardPlugin;

class WidgetBlueprintsController extends AbstractEntityController {

  protected function getEntityClass() { return 'DashboardPlugin\Entity\CustomWidgetBlueprints'; }
  protected function getViewsDirectory() { return 'plugins/dashboard/admin/widget-blueprints'; }
  protected function getRoutePrefix() { return '/admin/plugins/dasboard/widget-blueprints'; }
  protected function getRouteNamePrefix() { return 'admin_plugins_dashboard_widget_blueprints'; }

  public function getEntities($offset = 0, $limit = null) {
    return $this->get('dashboard')->getBlueprints();
  }

  public function getEntityEditForm($widget = null) {

  }

  public function getEntityDeleteForm($widget) {

  }

  public function saveEntityFromForm($form) {

  }

  public function deleteEntityFromForm($form) {

  }

}
