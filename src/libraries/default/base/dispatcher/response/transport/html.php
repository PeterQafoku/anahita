<?php

/** 
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 * 
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Dispatcher_Response
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2011 rmdStudio Inc./Peerglobe Technology Inc
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version    SVN: $Id: resource.php 11985 2012-01-12 10:53:20Z asanieyan $
 * @link       http://www.GetAnahita.com
 */

/**
 * Html Transport
 *
 * @category   Anahita
 * @package    Lib_Base
 * @subpackage Dispatcher_Response
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.GetAnahita.com
 */
 class LibBaseDispatcherResponseTransportHtml extends LibBaseDispatcherResponseTransportAbstract
 {
     /**
      * For all the success HTML responses unless its ajax, perform a redirect if the location
      * is set 
      * 
      * (non-PHPdoc)
      * @see LibBaseDispatcherResponseTransportAbstract::sendHeaders()
      */
     public function sendHeaders()
     {
         $response = $this->getResponse();
         $headers  = $response->getHeaders();
         
         if ( 
              isset($headers['Location']) && 
              $response->isSuccess() && 
              !$response->getRequest()->isAjax()
         ) 
         {
             $response->setStatus(KHttpResponse::SEE_OTHER);
         }
         
         return parent::sendHeaders();
     }
 }