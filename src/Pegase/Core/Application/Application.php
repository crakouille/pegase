<?php

namespace Pegase\Core\Application;

use Pegase\Core\Application\AbstractApplication;
use Pegase\Core\Http\Response\Response;

use Pegase\Core\Exception\Objects\PegaseException;
use Pegase\Core\Application\Event\ExceptionEvent;
use Pegase\Core\Application\Event\ApplicationEvent;

class Application extends AbstractApplication {
  
  public function __construct($params, $base_dir) {

    // Construction of the AbstractApplication

    parent::__construct($params, $base_dir);
    
    $mm = $this->sm->get('pegase.core.module_manager');
    // Services are now loaded
    
    try {

      // We send the event
      $event = new ApplicationEvent('application.loaded');
      $response = $this->sm->get('pegase.core.event_manager')->send($event);
  
      if($response != null) {
        $response->send();
        return; 
      }
      // get the router
      $router = $this->sm->get('pegase.core.router');
  
      $uri = $this->sm->get('pegase.core.request')->get_uri();
      $controller_and_method = $router->get_with_uri($uri);
  
      if($controller_and_method == null)
        echo "Router Error: The URI '" .  $uri . "' doesn't match with any route !";
      else {
        
        $controller = $controller_and_method[0];
        $method = $controller_and_method[1];
        $params = $controller_and_method[2];
      
        $response = call_user_func_array(array($controller, $method), $params);
        
        //PegaseException new NGException("test");
        $response->send(); 
      }

      $event = new ApplicationEvent('application.end');
      $this->sm->get('pegase.core.event_manager')->send($event);
    }
    catch (PegaseException $e) {
      $content = "<p>Caught PegaseException ('" . 
             str_replace("\n", '<br />', $e->getMessage()) . 
             "'):<br />" .
             str_replace("\n", '<br />', $e) .
             "</p>";

      $event = new ExceptionEvent("application.exception", $content);
      $response = $this->sm->get('pegase.core.event_manager')->send($event);

      if($response == null) {
        $response = new Response();

        // Getting the 'twig' service
        $twig = $this->sm->get('pegase.component.template.twig');
   
        // creating a response
        $response = new Response();

        $response->write(
          $twig->render(
            $mm->get_file('Pegase/Core', 'Application/Views/exception.twig.html'),
            array(
              'content' => $content
            )
          )
        );
      }

      $response->send(); 
    }
    // sinon ...
    catch (\Exception $e) {

      $content = "<p>Caught " . get_class($e) . " ('" . 
             str_replace("\n", '<br />', $e->getMessage()) . 
             "'):<br />" .
             str_replace("\n", '<br />', $e) .
             "</p>";
      
      $event = new ExceptionEvent("application.exception", $content);
      $response = $this->sm->get('pegase.core.event_manager')->send($event);

      if($response == null) {
        $response = new Response();

        // Getting the 'twig' service
        $twig = $this->sm->get('pegase.component.template.twig');
   
        // creating a response
        $response = new Response();
        
        $response->write(
          $twig->render(
            $mm->get_file('Pegase/Core', 'Application/Views/exception.twig.html'), 
//            'src/Pegase/Core/Application/Views/exception.twig.html',
            array(
              'content' => $content
            )
          )
        );
      }
      $response->send();
    }
  }

  public function get_base_dir() { 
    return $this->base_dir;  
  }
}

