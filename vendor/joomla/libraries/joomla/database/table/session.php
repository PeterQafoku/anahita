<?php
/**
* @version		$Id: session.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla.Framework
* @subpackage	Table
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Session table
 *
 * @package 	Joomla.Framework
 * @subpackage		Table
 * @since	1.0
 */
class JTableSession extends JTable
{
	/**
	 *
	 * @var int Primary key
	 */
	var $session_id	= null;

	/**
	 *
	 * @var string
	 */
	var $time	= null;

	/**
	 *
	 * @var string
	 */
	var $userid	= null;

	/**
	 *
	 * @var string
	 */
	var $usertype	= null;

	/**
	 *
	 * @var string
	 */
	var $username	= null;

	/**
	 *
	 * @var int
	 */
	var $guest = null;

	/**
	 *
	 * @var string
	 */
	var $data	= null;

	/**
	 * Constructor
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__session', 'session_id', $db );

		$this->guest 	= 1;
		$this->username = '';
		$this->usertype = 'public';
	}

	function loadByUser( $userId = 0 )
	{
		$userId = intval($userId);

		if(!$userId) {
				return false;
		}

		$this->reset();

		$db =& $this->getDBO();

		$query = 'SELECT *'
		. ' FROM '.$this->_tbl
		. ' WHERE userid = '.$userId;
		$db->setQuery( $query );

		if ($result = $db->loadAssoc( )) {
			return $this->bind($result);
		}
		else
		{
			$this->setError( $db->getErrorMsg() );
			return false;
		}
	}

	function insert($sessionId)
	{
		$this->session_id	= $sessionId;

		$this->time = time();
		$ret = $this->_db->insertObject( $this->_tbl, $this, 'session_id' );

		if( !$ret ) {
			$this->setError(strtolower(get_class( $this ))."::". AnTranslator::_( 'store failed' ) ."<br />" . $this->_db->stderr());
			return false;
		} else {
			return true;
		}
	}

	function update( $updateNulls = false )
	{
		$this->time = time();
		$ret = $this->_db->updateObject( $this->_tbl, $this, 'session_id', $updateNulls );

		if( !$ret ) {
			$this->setError(strtolower(get_class( $this ))."::". AnTranslator::_( 'store failed' ) ." <br />" . $this->_db->stderr());
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Destroys the pesisting session
	 */
	function destroy($userId)
	{
		$query = 'DELETE FROM `#__session` WHERE userid = '. (int) $userId;

		$this->_db->setQuery( $query );

		if (!$this->_db->query()) {
				$this->setError( $this->_db->stderr());
				return false;
		}

		return true;
	}

	/**
	* Purge old sessions
	*
	* @param int 	Session age in seconds
	* @return mixed Resource on success, null on fail
	*/
	function purge($maxLifetime = 1440)
	{
		$past = time() - $maxLifetime;
		// Index on 'VARCHAR'
		$query = 'DELETE FROM '. $this->_tbl .' WHERE ( time < \''. (int) $past .'\' )';
		$this->_db->setQuery($query);

		return $this->_db->query();
	}

	/**
	 * Find out if a user has a one or more active sessions
	 *
	 * @param int $userid The identifier of the user
	 * @return boolean True if a session for this user exists
	 */
	function exists($userid)
	{
		$query = 'SELECT COUNT(userid) FROM #__session'
			. ' WHERE userid = '. $this->_db->Quote( $userid );
		$this->_db->setQuery( $query );

		if ( !$result = $this->_db->loadResult() ) {
			$this->setError($this->_db->stderr());
			return false;
		}

		return (boolean) $result;
	}

	/**
	 * Overloaded delete method
	 *
	 * We must override it because of the non-integer primary key
	 *
	 * @access public
	 * @return true if successful otherwise returns and error message
	 */
	function delete( $oid=null )
	{
		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = $oid;
		}

		$query = 'DELETE FROM '.$this->_db->nameQuote( $this->_tbl ).
				' WHERE '.$this->_tbl_key.' = '. $this->_db->Quote($this->$k);
		$this->_db->setQuery( $query );

		if ($this->_db->query())
		{
			return true;
		}
		else
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	}
}
