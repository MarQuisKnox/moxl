<?php
/*
 * @file MucUser.php
 * 
 * @brief Handle incoming MUC roles
 * 
 * Copyright 2014 edhelas <edhelas@edhelas-laptop>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

namespace Moxl\Xec\Payload;

class MucUser extends Payload
{
    public function handle($stanza, $parent = false) {
        $room = current(explode('/',(string)$parent->attributes()->from));

        if((string)$parent->attributes()->to
        == (string)$stanza->item->attributes()->jid) {
            $cd = new \modl\ConferenceDAO();
            $conf = $cd->get($room);
            $conf->status = 1;
            $cd->set($conf);

            $evt = new \Event();
            $evt->runEvent('presencemuc', true);
        }
    }
}
