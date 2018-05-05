<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180428110704 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE `token` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(32) NOT NULL DEFAULT '',
                `password` VARCHAR(255) NOT NULL DEFAULT '',
                `email` VARCHAR(255) NOT NULL DEFAULT '',
                `is_active` INT(11) NOT NULL DEFAULT '0' COMMENT '',
                `role` INT(11) NOT NULL DEFAULT '0' COMMENT '',
                PRIMARY KEY (`id`)
            ) ENGINE=INNODB  DEFAULT CHARSET=utf8;
        ");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
