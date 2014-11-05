<?php
App::uses('DispatcherFilter', 'Routing');
App::uses('TNumeric', 'Tongue.Lib/TypeHinting');

/**
 * TongueDispatcher
 *
 */
class TongueDispatcher extends DispatcherFilter {

/**
 * beforeDispatch
 *
 * @param CakeEvent $event
 */
    public function beforeDispatch(CakeEvent $event) {
        $request = $event->data['request'];
        $response = $event->data['response'];
        $controller = $this->_getController($request, $response);

        try {
            $method = new ReflectionMethod($controller, $request->params['action']);
            $params = $method->getParameters();
            foreach ($params as $i => $param) {
                $className = $param->getClass()->getName();
                if (!$className) {
                    continue;
                }
                $type = new $className($request->params['pass'][$i]);
                $type->check();
                $request->params['pass'][$i] = $type;
            }
        } catch (ReflectionException $e) {
            throw new MissingActionException(array(
                'controller' => $controller->name . "Controller",
                'action' => $request->params['action']
            ));
        }

        return;
    }

/**
 * copy from lib/Cake/Routing/Dispatcher.php
 * -----------------------------------------
 * Get controller to use, either plugin controller or application controller
 *
 * @param CakeRequest $request Request object
 * @param CakeResponse $response Response for the controller.
 * @return mixed name of controller if not loaded, or object if loaded
 */
    protected function _getController($request, $response) {
        $ctrlClass = $this->_loadController($request);
        if (!$ctrlClass) {
            return false;
        }
        $reflection = new ReflectionClass($ctrlClass);
        if ($reflection->isAbstract() || $reflection->isInterface()) {
            return false;
        }
        return $reflection->newInstance($request, $response);
    }

/**
 * copy from lib/Cake/Routing/Dispatcher.php
 * -----------------------------------------
 * Load controller and return controller class name
 *
 * @param CakeRequest $request Request instance.
 * @return string|bool Name of controller class name
 */
    protected function _loadController($request) {
        $pluginName = $pluginPath = $controller = null;
        if (!empty($request->params['plugin'])) {
            $pluginName = $controller = Inflector::camelize($request->params['plugin']);
            $pluginPath = $pluginName . '.';
        }
        if (!empty($request->params['controller'])) {
            $controller = Inflector::camelize($request->params['controller']);
        }
        if ($pluginPath . $controller) {
            $class = $controller . 'Controller';
            App::uses('AppController', 'Controller');
            App::uses($pluginName . 'AppController', $pluginPath . 'Controller');
            App::uses($class, $pluginPath . 'Controller');
            if (class_exists($class)) {
                return $class;
            }
        }
        return false;
    }
}
