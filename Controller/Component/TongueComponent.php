<?php
App::uses('TNumeric', 'Tongue.Lib/TypeHinting');
App::uses('TNaturalNumber', 'Tongue.Lib/TypeHinting');

class TongueComponent extends Component {

    /**
    * startup
    *
    *
    *
    */
    public function startup(Controller $controller) {

        try {

            $action = $controller->request->params['action'];
            $method = new ReflectionMethod($controller, $action);
            $params = $method->getParameters();

            $pass = $controller->request->params['pass'];

            if ( !empty($params) ) {
                foreach ($params as $i => $param) {

                    $class = $param->getClass();
                    // Class unspecified case
                    if (is_null($class)) {
                        continue;
                    }

                    $className = $class->getName();
                    if (!$className) {
                        continue;
                    }
                    if (isset($pass[$i])) {
                        $value = $pass[$i];
                    } else {
                        $value = null;
                    }
                    $type = new $className($value);
                    if (!($type instanceof TongueTypeInterface)) {
                        throw new LogicException($className . ' should be instance of TongueTypeInterface.');
                    }
                    $type->check();
                    $controller->request->params['pass'][$i] = $type;
                }
            }

        } catch (ReflectionException $e) {
            throw new MissingActionException(array(
                'controller' => $controller->name . "Controller",
                'action' => $action
            ));
        }
    }
}
