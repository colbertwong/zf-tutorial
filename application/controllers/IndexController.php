<?php
/**
 * Created by PhpStorm.
 * User: colbe
 * Date: 2018/2/25
 * Time: 16:47
 */

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->title = 'My Albums';
        $albums = new Albums();
        $this->view->albums = $albums->fetchAll();
    }

    public function addAction()
    {
        $this->view->title = 'Add New Album';
        $form = new AlbumForm();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $ablums = new Albums();
                $row = $ablums->createRow();
                $row->artist = $form->getValue('artist');
                $row->title = $form->getValue('title');
                $row->save();
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $this->view->title = 'Edit Album';
        $form = new AlbumForm();
        $form->submit->setLabel('Edit');
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $ablums = new Albums();
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $row = $ablums->fetchRow('id=' . $id);
                $row->artist = $form->getValue('artist');
                $row->title = $form->getValue('title');
                $row->save();
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }

        } else {
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $ablums = new Albums();
                $ablum = $ablums->fetchRow('id=' . $id);
                $form->populate($ablum->toArray());
            }
        }

    }

    public function deleteAction()
    {
        $this->view->title = 'Delete Album';
        if ($this->_request->isPost()) {
            $id = (int) $this->_request->getPost('id');
            $del = $this->_request->getPost('del');
            if ($del == 'Yes' && $id > 0) {
                $albums = new Albums();
                $where = 'id = ' . $id;
                $albums->delete($where);
            }
            $this->_redirect('/');
        } else {
            $id = (int) $this->_request->getParam('id');
            if ($id > 0) {
                $ablums = new Albums();
                $this->view->ablum = $ablums->fetchRow('id=' . $id);
            }
        }
    }

}