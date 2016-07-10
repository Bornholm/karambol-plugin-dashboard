<?php

namespace DashboardPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use DashboardPlugin\Widget\WidgetBlueprintInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="widget_blueprints")
 */
class CustomWidgetBlueprint implements WidgetBlueprintInterface {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * @ORM\Column(type="name", nullable=false)
   */
  protected $name;

  /**
   * @ORM\Column(type="description", nullable=false)
   */
  protected $description;

  /**
   * @ORM\Column(type="url", nullable=false)
   */
  protected $url;

  public function getId() {
    return $this->id;
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
