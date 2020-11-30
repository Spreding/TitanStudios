<?php

namespace App\EventSuscriber;

use App\Entity\Actualite;
use App\Entity\CompanyMembers;
use App\Entity\Realisations;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class EasyAdminSubscriber implements EventSubscriberInterface{

    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    public static function getSubscribedEvents()
    {
        return[
            BeforeEntityPersistedEvent::class =>['setImage'],
            BeforeEntityPersistedEvent::class =>['setLinks'],
            BeforeEntityUpdatedEvent::class =>['updateImage'],
            BeforeEntityUpdatedEvent::class =>['updateLinks']
        ];
    }

    public function setLinks(BeforeEntityPersistedEvent $event){
        if(!($event->getEntityInstance() instanceof Realisations)){
            return;
        }
    }

    public function updateLinks(BeforeEntityUpdatedEvent $event){
        if(!($event->getEntityInstance() instanceof Realisations)){
            return;
        }
    }

    public function updateImage(BeforeEntityUpdatedEvent $event)
    {
        dd('ici');
        if(!($event->getEntityInstance() instanceof Realisations) && !($event->getEntityInstance() instanceof CompanyMembers) && !($event->getEntityInstance() instanceof Actualite)){
            return;
        }

        $reflexion = new ReflectionClass($event->getEntityInstance());
        $entityName = $reflexion->getShortName();
        dd($entityName);
        if($_FILES[$entityName]['name']['illustration'] != ''){
            $this->uploadImage($event, $entityName);
        }

    }

    public function setImage(BeforeEntityPersistedEvent $event)
    {
        if(!($event->getEntityInstance() instanceof Realisations) && !($event->getEntityInstance() instanceof CompanyMembers) && !($event->getEntityInstance() instanceof Actualite)){
            return;
        }

        $reflexion = new ReflectionClass($event->getEntityInstance());
        $entityName = $reflexion->getShortName();

        $this->uploadImage($event, $entityName);

    }

    public function uploadImage($event, $entityName)
    {
        $entity = $event->getEntityInstance();

        $tmp_name = $_FILES[$entityName]['tmp_name']['illustration'];
        $filename =uniqid();
        $extension = pathinfo($_FILES[$entityName]['name']['illustration'], PATHINFO_EXTENSION);


        $project_dir = $this->appKernel->getProjectDir();
        move_uploaded_file($tmp_name, $project_dir.'/public/uploads/'.$filename.'.'.$extension);
        $entity->setIllustration($filename.'.'.$extension);
    }
}