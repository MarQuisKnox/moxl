<?php

namespace Moxl\Stanza;

class Bookmark {
    static function get()
    {  
        $xml = '
        <pubsub xmlns="http://jabber.org/protocol/pubsub">
            <items node="storage:bookmarks"/>
        </pubsub>';
            
        $xml = \Moxl\API::iqWrapper($xml, false, 'get');
        \Moxl\API::request($xml);
    }

    static function set($arr)
    {
        $xml = '';
        
        foreach($arr as $elt) {
            switch ($elt['type']) {
                case 'conference':
                    $xml .= '
                        <conference name="'.$elt['name'].'"
                                    autojoin="'.$elt['autojoin'].'"
                                    jid="'.$elt['jid'].'">
                            <nick>'.$elt['nick'].'</nick>
                        </conference>';
                    break;
                /*case 'url':
                    $xml .= '
                        <url name="'.$elt['name'].'"
                             url="'.$elt['url'].'"/>';
                    break;*/
                case 'subscription':
                    $xml .= '
                        <subscription 
                            xmlns="urn:xmpp:pubsub:subscription:0"
                            server="'.$elt['server'].'" 
                            node="'.$elt['node'].'" 
                            subid="'.$elt['subid'].'">
                            <title>'.$elt['title'].'</title>
                        </subscription>';
                    break;
            }       
        }
        
        $xml = '
        <pubsub xmlns="http://jabber.org/protocol/pubsub">
            <publish node="storage:bookmarks">
                <item id="current">
                    <storage xmlns="storage:bookmarks">
                        '.$xml.'
                    </storage>
                </item>
            </publish>
        </pubsub>';

        $xml = \Moxl\API::iqWrapper($xml, false, 'set');
        \Moxl\API::request($xml);
    }

}
