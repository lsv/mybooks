<?php
namespace AppBundle\Form;

use AppBundle\Document\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Bog navn'
        ]);

        $builder->add('saxo_url', UrlType::class, [
            'label' => 'URL to SAXO',
            'required' => false
        ]);

        $builder->add('download_url', UrlType::class, [
            'label' => 'Download url'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class
        ]);
    }


}
