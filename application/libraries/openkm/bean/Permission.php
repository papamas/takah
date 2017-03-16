<?php

/**
 * OpenKM, Open Document Management System (http://www.openkm.com)
 * Copyright (c) 2006-2014 Paco Avila & Josep Llort
 * 
 * No bytes were intentionally harmed during the development of this application.
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace openkm\bean;

/**
 * Permission
 *
 * @author sochoa
 */
class Permission {

    const NONE = 0;     // 00000
    const READ = 1;     // 00001
    const WRITE = 2;    // 00010
    const DELETE = 4;   // 00100
    const SECURITY = 8; // 01000
    const MOVE = 16;    // 10000
    // Extended security
    const DOWNLOAD = 1024;
    const START_WORKFLOW = 2048;
    const COMPACT_HISTORY = 4096;
    const PROPERTY_GROUP = 8192;
    // All grants
    const ALL_GRANTS = 'READ | WRITE | DELETE | SECURITY';

}

?>