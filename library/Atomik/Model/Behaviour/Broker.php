<?php
/**
 * Atomik Framework
 * Copyright (c) 2008-2009 Maxime Bouroumeau-Fuseau
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package Atomik
 * @subpackage Model
 * @author Maxime Bouroumeau-Fuseau
 * @copyright 2008-2009 (c) Maxime Bouroumeau-Fuseau
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://www.atomikframework.com
 */

/** Atomik_Model_Behaviour_Interface */
require_once 'Atomik/Model/Behaviour/Interface.php';

/** Atomik_Model_Behaviour_Factory */
require_once 'Atomik/Model/Behaviour/Factory.php';

/**
 * @package Atomik
 * @subpackage Model
 */
class Atomik_Model_Behaviour_Broker
{
	/**
	 * @var Atomik_Model_Descriptor
	 */
	protected $_descriptor;
	
	/**
	 * @var array
	 */
	protected $_behaviours = array();
	
	/**
	 * Constructor
	 * 
	 * @param Atomik_Model_Descriptor $descriptor
	 */
	public function __construct(Atomik_Model_Descriptor $descriptor = null)
	{
		$this->_descriptor = $descriptor;
	}
	
	/**
	 * Resets behaviours
	 * 
	 * @param array $behaviours
	 */
	public function setBehaviours($behaviours)
	{
		$this->_behaviours = array();
		foreach ($behaviours as $behaviour) {
			$this->addBehaviour($behaviour);
		}
	}
	
	/**
	 * Adds a behaviour
	 * 
	 * @param Atomik_Model_Behaviour_Interface $behaviour
	 */
	public function addBehaviour(Atomik_Model_Behaviour_Interface $behaviour)
	{
		$this->_behaviours[get_class($behaviour)] = $behaviour;
		if ($this->_descriptor !== null) {
			$behaviour->init($this->_descriptor);
		}
	}
	
	/**
	 * Checks if the behaviour with the specified class name exists
	 * 
	 * @param	string	$behaviourClassName
	 * @return 	bool
	 */
	public function hasBehaviour($behaviourClassName)
	{
		return isset($this->_behaviours[$behaviourClassName]);
	}
	
	/**
	 * Returns all behaviours
	 * 
	 * @return array
	 */
	public function getBehaviours()
	{
		return $this->_behaviours;
	}
	
	/**
	 * Notify behaviours of an event
	 * 
	 * @param	string	$event
	 * @param	array	$args
	 */
	public function notify($event, $args = array())
	{
		foreach ($this->_behaviours as $behaviour) {
			call_user_func_array(array($behaviour, $event), $args);
		}
	}
	
	/**
	 * Allows to notify behaviours using method like notifyEventName(...)
	 * 
	 * @param	string	$method
	 * @param	array	$args
	 */
	public function __call($method, $args)
	{
		if (substr($method, 0, 6) == 'notify') {
			$event = substr($method, 6);
			$event{0} = strtolower($event{0});
			return $this->notify($event, $args);
		}
		
		require_once 'Atomik/Model/Behaviour/Exception.php';
		throw new Atomik_Model_Behaviour_Exception('Method ' . $method . ' does not exist');
	}
}