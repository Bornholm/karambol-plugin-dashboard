<?php

namespace DashboardPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

class CustomWidgetBlueprintType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
        ->add('name', Type\TextType::class, [
          'label' => 'plugins.dashboard.admin.widget_blueprints.blueprint_name',
          'required' => true
        ])
        ->add('description', Type\TextType::class, [
          'label' => 'plugins.dashboard.admin.widget_blueprints.blueprint_description',
          'required' => true
        ])
        ->add('url', Type\TextType::class, [
          'label' => 'plugins.dashboard.admin.widget_blueprints.blueprint_url',
          'required' => true
        ])
        ->add('submit', Type\SubmitType::class, [
          'label' => 'plugins.dashboard.admin.widget_blueprints.save_blueprint',
          'attr' => [
            'class' => 'btn-success'
          ]
        ])
      ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
        'data_class' => 'DashboardPlugin\Entity\CustomWidgetBlueprint',
        'cascade_validation' => true
      ]);
    }
}
