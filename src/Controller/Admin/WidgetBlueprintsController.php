<?php

namespace DashboardPlugin\Controller\Admin;

use Karambol\Controller\AbstractEntityController;
use Symfony\Component\Form\Extension\Core\Type as Type;
use DashboardPlugin\DashboardPlugin;
use DashboardPlugin\Entity\CustomWidgetBlueprint;
use DashboardPlugin\Form\Type\CustomWidgetBlueprintType;

class WidgetBlueprintsController extends AbstractEntityController {

  protected function getEntityClass() { return 'DashboardPlugin\Entity\CustomWidgetBlueprint'; }
  protected function getViewsDirectory() { return 'plugins/dashboard/admin/widget-blueprints'; }
  protected function getRoutePrefix() { return '/admin/plugins/dasboard/widget-blueprints'; }
  protected function getRouteNamePrefix() { return 'admin_plugins_dashboard_widget_blueprints'; }

  public function getEntities($offset = 0, $limit = null) {
    return $this->get('dashboard')->getBlueprints();
  }

  public function getEntityEditForm($blueprint = null) {

    $formFactory = $this->get('form.factory');
    $urlGen = $this->get('url_generator');

    if($blueprint === null) $blueprint = new CustomWidgetBlueprint();

    $formBuilder = $formFactory->createBuilder(CustomWidgetBlueprintType::class, $blueprint);
    $routeName = $this->getRouteName(self::UPSERT_ACTION);
    $action = $urlGen->generate($routeName, ['entityId' => $blueprint->getId()]);

    return $formBuilder->setAction($action)
      ->setMethod('POST')
      ->getForm()
    ;

  }

  public function getEntityDeleteForm($blueprint) {

    $formFactory = $this->get('form.factory');
    $urlGen = $this->get('url_generator');

    $formBuilder = $formFactory->createBuilder(Type\FormType::class);

    return $formBuilder
      ->add('blueprintId', Type\HiddenType::class, [
        'data' => $blueprint->getId(),
        'required' => true
      ])
      ->add('submit', Type\SubmitType::class, [
        'label' => 'plugins.dashboard.admin.widget_blueprints.delete_blueprint',
        'attr' => [
          'class' => 'btn-danger'
        ]
      ])
      ->setAction($urlGen->generate($this->getRouteName(self::DELETE_ACTION), ['entityId' => $blueprint->getId()]))
      ->setMethod('DELETE')
      ->getForm()
    ;

  }

  public function saveEntityFromForm($form) {

    $orm = $this->get('orm');
    $blueprint = $form->getData();

    if($blueprint->getId() === null) {
      $orm->persist($blueprint);
    }

    $orm->flush();

    return $blueprint;

  }

  public function deleteEntityFromForm($form) {

    $orm = $this->get('orm');
    $data = $form->getData();

    if(!isset($data['blueprintId'])) {
      // TODO add flash message to indicate error
      return false;
    }

    $widgetBlueprint = $orm->getRepository($this->getEntityClass())->find($data['blueprintId']);

    if(!$widgetBlueprint) {
      // TODO add flash message to indicate error
      return false;
    }

    $orm->remove($widgetBlueprint);
    $orm->flush();

    return true;


  }

}
