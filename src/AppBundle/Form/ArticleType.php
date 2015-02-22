<?php 

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {
	
    public function buildForm(FormBuilderInterface $builder, array $options) {
    	
        $builder
            ->add('articleTitle', 'text')
            ->add('articleDescription', 'ckeditor')
        	->add('articleContent', 'ckeditor')        
            ->add('articleCreationDate', 'date')
            ->add('articlePublished', 'choice', 
            		array(
            			'choices' => array(
            					'1' => $options['yes'],
            					'0' => $options['no']
            		),
            		'expanded' => true,
            		'multiple' => false
            	)
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
        	array(
            	'data_class' => 'AppBundle\Entity\Article',
        		'yes' => null,
        		'no' => null
        	)
        );
    }

    public function getName() {
        return 'article';
    }
}