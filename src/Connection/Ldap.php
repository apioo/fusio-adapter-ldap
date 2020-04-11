<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fusio\Adapter\Ldap\Connection;

use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;
use Symfony\Component\Ldap\Ldap as LdapConnection;

/**
 * Ldap
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Ldap implements ConnectionInterface
{
    public function getName()
    {
        return 'LDAP';
    }

    /**
     * @param \Fusio\Engine\ParametersInterface $config
     * @return \Symfony\Component\Ldap\LdapInterface
     */
    public function getConnection(ParametersInterface $config)
    {
        $options = [
            'host' => $config->get('host'),
            'port' => $config->get('port') ?: 389,
            'encryption' => $config->get('encryption') ?: 'none',
        ];

        return LdapConnection::create('ext_ldap', $options);
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory)
    {
        $options = [
            'none' => 'None',
            'ssl'  => 'SSL',
            'tls'  => 'TLS',
        ];

        $builder->add($elementFactory->newInput('host', 'Host', 'text', 'IP or hostname of the LDAP server'));
        $builder->add($elementFactory->newInput('port', 'Port', 'number', 'Port used to access the LDAP server'));
        $builder->add($elementFactory->newSelect('encryption', 'Encryption', $options, 'The encryption protocol'));
    }
}
