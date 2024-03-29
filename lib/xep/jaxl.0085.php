<?php
/* Jaxl (Jabber XMPP Library)
 *
 * Copyright (c) 2009-2010, Abhinav Singh <me@abhinavsingh.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Abhinav Singh nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRIC
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

    /*
     * XEP-0085: Chat State Notifications
     * Adds 5 chat state a.k.a 'composing', 'paused', 'active', 'inactive', 'gone'
    */
    class JAXL0085 {

        public static $ns = 'http://jabber.org/protocol/chatstates';        
        public static $chatStates = array('composing', 'active', 'inactive', 'paused', 'gone');
        
        public static function init($jaxl) {
            $jaxl->features[] = self::$ns;
            
            JAXLXml::addTag('message', 'composing', '//message/composing/@xmlns');
            JAXLXml::addTag('message', 'active', '//message/active/@xmlns');
            JAXLXml::addTag('message', 'inactive', '//message/inactive/@xmlns');
            JAXLXml::addTag('message', 'paused', '//message/paused/@xmlns');
            JAXLXml::addTag('message', 'gone', '//message/gone/@xmlns');
            JAXLPlugin::add('jaxl_get_message', array('JAXL0085', 'getMessage'));
        }
        
        public static function getMessage($payloads, $jaxl) {
            foreach($payloads as $key => $payload) {
                $payload['chatState'] = false;
                
                foreach(self::$chatStates as $state) {
                    if(isset($payload[$state]) && $payload[$state] == self::$ns) {
                        $payload['chatState'] = $state;
                    }
                    unset($payload[$state]);
                }
                
                $payloads[$key] = $payload;
            }
            
            return $payloads;
        }
        
    }
    
?>
