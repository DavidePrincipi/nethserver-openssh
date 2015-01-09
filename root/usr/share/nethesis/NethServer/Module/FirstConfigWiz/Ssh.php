<?php

namespace NethServer\Module\FirstConfigWiz;

/*
 * Copyright (C) 2014  Nethesis S.r.l.
 *
 * This script is part of NethServer.
 *
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * TODO: add component description here
 *
 * @author Davide Principi <davide.principi@nethesis.it>
 * @since 1.6
 */
class Ssh extends \Nethgui\Controller\AbstractController {

    public $wizardPosition = 60;

    protected function initializeAttributes(\Nethgui\Module\ModuleAttributesInterface $attributes) {
        return new \NethServer\Tool\CustomModuleAttributesProvider($attributes, array('languageCatalog' => 'NethServer_Module_Ssh'));
    }

    public function initialize() {
        parent::initialize();
        $this->declareParameter('port', \Nethgui\System\NethPlatform::PORTNUMBER, array('configuration', 'sshd', 'TCPPort'));
    }

    protected function onParametersSaved($changes)
    {
        $this->getParent()->storeAction(array(
            'message' => array(
                'module' => $this->getIdentifier(),
                'id' => 'Ssh_Action',
                'args' => $this->parameters->getArrayCopy()
            ),
            'events' => array('nethserver-openssh-save')
        ));        
    }

    public function nextPath() {
        if ($this->getRequest()->hasParameter('skip') || $this->getRequest()->isMutation()) {
            $successor = $this->getParent()->getSuccessor($this);
            return $successor ? $successor->getIdentifier() : 'Review';
        }
        return parent::nextPath();
    }

}
