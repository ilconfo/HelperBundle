<?php

namespace Offtune\HelperBundle\EventListener;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class LastRouteListener
{

    public function onKernelRequest(GetResponseEvent $event)
    {
        // Do not save subrequests
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        $routeName = $request->get('_route');
        $routeParams = $request->get('_route_params');
        if ($routeName[0] == '_') {
            return;
        }

        if (strpos($routeName, 'api_') !== false)
        	return;
        if (strpos($routeName, '_create') !== false)
        	return;
        if (strpos($routeName, '_update') !== false)
        	return;

        $routeData = array('name' => $routeName, 'params' => $routeParams);

        // Do not save same matched route twice
        $thisRoute = $session->get('this_route', array());
        if ($thisRoute == $routeData) {
            return;
        }

        $session->set('pre_last_route', $session->get('last_route', []));
        $session->set('last_route', $thisRoute);
        $session->set('this_route', $routeData);
    }
}