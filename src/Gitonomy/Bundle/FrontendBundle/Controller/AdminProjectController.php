<?php

namespace Gitonomy\Bundle\FrontendBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Gitonomy\Bundle\CoreBundle\Entity\Role;
use Gitonomy\Bundle\FrontendBundle\Form\Role\RoleType;
use Gitonomy\Bundle\CoreBundle\Entity\Repository;

/**
 * Controller for repository actions.
 *
 * @author Julien DIDIER <julien@jdidier.net>
 */
class AdminProjectController extends BaseAdminController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getEntityManager()->getRepository('GitonomyCoreBundle:Project');
    }

    public function listAction()
    {
        $this->assertPermission(array('PROJECT_ADMIN'));

        return parent::listAction();
    }

    public function createAction()
    {
        $this->assertPermission('PROJECT_CREATE');

        return parent::createAction();
    }

    protected function postCreate($object)
    {
        $repository = new Repository();
        $repository->setProject($object);
        $object->addRepository($repository);

        $git = $this->get('gitonomy_core.git.repository_pool');
        $git->create($repository);
        $this->getDoctrine()->getEntityManager()->flush();
    }

    public function editAction($id)
    {
        $this->assertPermission('PROJECT_EDIT');

        return parent::editAction($id);
    }

    public function deleteAction($id)
    {
        $this->assertPermission('PROJECT_DELETE');

        return parent::deleteAction($id);
    }
}
