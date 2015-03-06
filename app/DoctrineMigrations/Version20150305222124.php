<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150305222124 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trainningsession CHANGE content content LONGTEXT DEFAULT NULL, CHANGE details details LONGTEXT DEFAULT NULL, CHANGE requirements requirements LONGTEXT DEFAULT NULL, CHANGE subscription subscription LONGTEXT DEFAULT NULL, CHANGE review review LONGTEXT DEFAULT NULL, CHANGE equipment equipment LONGTEXT DEFAULT NULL, CHANGE transport transport LONGTEXT DEFAULT NULL, CHANGE rules rules LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trainningsession CHANGE content content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE details details LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE requirements requirements LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE subscription subscription LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE review review LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE equipment equipment LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE transport transport LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE rules rules LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
    }
}
