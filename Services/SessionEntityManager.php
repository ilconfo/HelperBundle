<?php

namespace Offtune\HelperBundle\Services;

class SessionEntityManager
{
    public $request;
    public $logger;

    public function __construct($requestStack, $logger)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->logger = $logger;
    }

    public function getListFromSession($listName)
    {
        return $this->request->getSession()->get($listName);
    }

    public function removeListFromSession($listName)
    {
        // echo "remove";die();
        $this->logger->info('REMOVE FROM SESSION ' . $listName);
        $this->request->getSession()->remove($listName);
    }

    public function saveInSession($object, $listName, $id = '')
    {
        if ($id === '') {
            $id = uniqid();
        }
        $this->logger->info('Session: set in ' . $listName . ' object with id ' . $id);

        $list = $this->getList($listName);

        $list[$id] = $object;
        $this->request->getSession()->set($listName, $list);

        $res = $this->getFromSession($listName, $id);

        return $id;
    }

    public function getFromSession($listName, $id)
    {
        $this->logger->info('Session: get from ' . $listName . ' object with id ' . $id);
        $list = $this->getList($listName);

        if (array_key_exists($id, $list)) {
            return $list[$id];
        }

        return null;
    }

    public function removeFromSession($listName, $id)
    {
        $list = $this->getList($listName);

        if (array_key_exists($id, $list)) {
            unset($list[$id]);
        }
    }

    public function getList($listName)
    {
        $list = $this->request->getSession()->get($listName);
        if (!is_array($list)) {
            $list = array();
        }

        return $list;
    }
}
