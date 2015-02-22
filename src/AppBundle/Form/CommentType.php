<?php 

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {
	
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        	->add('commentAuthor', 'text')
        	->add('commentAuthorEmail', 'text')
            ->add('commentContent', 'textarea')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment'
        ));
    }

    public function getName() {
        return 'comment';
    }
}
