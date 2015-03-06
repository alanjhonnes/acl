<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150305215439 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trainningsession (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date DATE NOT NULL, content LONGTEXT NOT NULL, details LONGTEXT NOT NULL, requirements LONGTEXT NOT NULL, subscription LONGTEXT NOT NULL, review LONGTEXT NOT NULL, equipment LONGTEXT NOT NULL, transport LONGTEXT NOT NULL, rules LONGTEXT NOT NULL, INDEX IDX_3C16B5B312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainningsession_audit (id INT NOT NULL, rev INT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, content LONGTEXT DEFAULT NULL, details LONGTEXT DEFAULT NULL, requirements LONGTEXT DEFAULT NULL, subscription LONGTEXT DEFAULT NULL, review LONGTEXT DEFAULT NULL, equipment LONGTEXT DEFAULT NULL, transport LONGTEXT DEFAULT NULL, rules LONGTEXT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trainningsession ADD CONSTRAINT FK_3C16B5B312469DE2 FOREIGN KEY (category_id) REFERENCES classification__category (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trainningsession');
        $this->addSql('DROP TABLE trainningsession_audit');
    }
}
