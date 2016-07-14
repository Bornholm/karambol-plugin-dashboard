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
   * @ORM\Column(type="string", length=50, nullable=false)
   */
  protected $name;

  /**
   * @ORM\Column(type="text", nullable=false)
   */
  protected $description;

  /**
   * @ORM\Column(type="text", length=254, nullable=false)
   */
  protected $url;

  public function getId() {
    return $this->id;
  }

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
