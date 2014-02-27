<?php

namespace CsnUser\Controller;


use CsnUser\Form\UserFilter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use CsnUser\Form\UserForm;

class UserController extends AbstractActionController
{
    private $albumTable;
     //Crude
    //retrive
    //R- retrive
    public function indexAction()
    {
        $this -> getAlbumTable() -> select();
        return new ViewModel(array('rowset' => $this->getAlbumTable()->select()));

    }
    //C - Create

    public function createAction()
    {
        $form = new UserForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new UserFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $this->getAlbumTable()->insert($data);
                return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user', 'action' => 'index'));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    //Update
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('csn_user/default', array(
                'controller' => 'user',
                'action' => 'index'
            ));
        }
        /*$form = $this->getAlbumTable()->getAlbum($id);*/

        $form  = new UserForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new UserFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form -> getData();
                unset($data['submit']);
                $this -> getAlbumTable() -> update($data, array('id' => $id));

                return $this->redirect()->toRoute('csn_user/default',array(
                    'controller' => 'user',
                    'action' => 'index'
                ));
            }
        }
        else {
            $form->setData($this->getAlbumTable()->select(array('id' => $id))->current());
        }

        return new ViewModel(array(
            'id' => $id,
            'form' => $form,
        ));

    }
    //delete
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        if ($id) {
            $this->getAlbumTable()->delete(array('id' => $id));
        }
        return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user', 'action' => 'index'));


    }

    public function getAlbumTable()
    {
      if(!$this -> albumTable){
          $this -> albumTable = new TableGateway(
              'album',
              $this -> getServiceLocator() -> get('Zend\Db\Adapter\Adapter')
          //new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object
          //ResultSetPrototype
          );

      }
        return $this -> albumTable;
    }

}