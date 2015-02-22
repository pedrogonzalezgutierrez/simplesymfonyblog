<?php 

namespace AppBundle\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchByTitleType extends AbstractType {
	
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Search\SearchByTitle'
        ));
    }

    public function getName() {
        return 'searchbytitle';
    }
}
