<?php

namespace soweredu\server;

/**
 * Class RestServer
 * @package soweredu\server
 */
class RestServer {
	private $serviceClasses = array();

	/**
	 * @param $serviceClass
	 */
	public function addServiceClass($serviceClass) {
		$this->serviceClasses[] = $serviceClass;
	}

    /**
     * [handle 处理请求]
     */
	public function handle() {
		$requestAttributes = $this->getRequestAttributeArray();
		if ($this->methodIsDefinedInRequest()) {
			$method       = $requestAttributes["method"];
			$serviceClass = $this->getClassContainingMethod($method);

			if ($serviceClass != null) {
				$ref = new ReflectionMethod($serviceClass, $method);
				if (!$ref->isPublic()) {
					echo json_encode(array('error' => 'API call is invalid.'));
					return;
				}
				$params     = $ref->getParameters();
				$paramCount = count($params);
				$pArray     = array();
				$paramStr   = "";

				$iterator = 0;

				foreach ($params as $param) {
					$pArray[strtolower($param->getName())] = null;
					$paramStr .= $param->getName();
					if ($iterator != $paramCount-1) {
						$paramStr .= ", ";
					}

					$iterator++;
				}
				foreach ($pArray as $key => $val) {
					$pArray[strtolower($key)] = $requestAttributes[strtolower($key)];
				}

				if (count($pArray) == $paramCount && !in_array(null, $pArray)) {
					$result = call_user_func_array(array($serviceClass, $method), $pArray);
					if ($result != null) {
						echo json_encode($result);
					}
				} else {
					echo json_encode(array('error' => "Required parameter(s) for ".$method.": ".$paramStr));
				}
			} else {
				echo json_encode(array('error' => "The method ".$method." does not exist."));
			}
		} else {
			echo json_encode(array('error' => 'No method was requested.'));
		}
	}

	/**
	 * [getClassContainingMethod description]
	 * @param  [type] $method [description]
	 * @return [type]         [description]
	 */
	private function getClassContainingMethod($method) {
		$serviceClass = null;
		foreach ($this->serviceClasses as $class) {
			if ($this->methodExistsInClass($method, $class)) {
				$serviceClass = $class;
			}
		}
		return $serviceClass;
	}

    /**
     * [methodExistsInClass description]
     * @param $method
     * @param $class
     * @return bool [type]         [description]
     * @internal param $ [type] $method [description]
     * @internal param $ [type] $class  [description]
     */
	private function methodExistsInClass($method, $class) {
		return method_exists($class, $method);
	}

    /**
     * [methodIsDefinedInRequest description]
     * @return bool [type] [description]
     */
	private function methodIsDefinedInRequest() {
		return array_key_exists("method", $this->getRequestAttributeArray());
	}

    /**
     * [getRequestAttributeArray description]
     * @return array [type] [description]
     */
	private function getRequestAttributeArray() {
		return array_change_key_case($_REQUEST, CASE_LOWER);
	}
}
