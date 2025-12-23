<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Adapter\Ldap\Tests\Connection;

use Fusio\Adapter\Ldap\Connection\Ldap;
use Fusio\Adapter\Ldap\Tests\LdapTestCase;
use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\Form\Builder;
use Fusio\Engine\Form\Container;
use Fusio\Engine\Form\Element\Input;
use Fusio\Engine\Form\Element\Select;
use Fusio\Engine\Parameters;
use Symfony\Component\Ldap\LdapInterface;

/**
 * LdapTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org/
 */
class LdapTest extends LdapTestCase
{
    public function testGetConnection(): void
    {
        /** @var Ldap $connectionFactory */
        $connectionFactory = $this->getConnectionFactory()->factory(Ldap::class);

        $config = new Parameters([
            'host' => '127.0.0.1',
            'port' => '',
            'encryption' => '',
        ]);

        $connection = $connectionFactory->getConnection($config);

        $this->assertInstanceOf(LdapInterface::class, $connection);
    }

    public function testConfigure(): void
    {
        $connection = $this->getConnectionFactory()->factory(Ldap::class);
        $builder    = new Builder();
        $factory    = $this->getFormElementFactory();

        $this->assertInstanceOf(ConfigurableInterface::class, $connection);

        $connection->configure($builder, $factory);

        $this->assertInstanceOf(Container::class, $builder->getForm());

        $elements = $builder->getForm()->getElements();
        $this->assertEquals(3, count($elements));
        $this->assertInstanceOf(Input::class, $elements[0]);
        $this->assertInstanceOf(Input::class, $elements[1]);
        $this->assertInstanceOf(Select::class, $elements[2]);
    }
}
