<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141127165257 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE brand_audit (id INT NOT NULL, rev INT NOT NULL, name VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE product_media');
        $this->addSql('DROP TABLE product_video');
        $this->addSql('ALTER TABLE product ADD softwares_id INT DEFAULT NULL, ADD subname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE67D8904 FOREIGN KEY (softwares_id) REFERENCES media__gallery (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADE67D8904 ON product (softwares_id)');
        $this->addSql('ALTER TABLE product_audit ADD softwares_id INT DEFAULT NULL, ADD subname VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE product_media (product_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_CB70DA504584665A (product_id), INDEX IDX_CB70DA50EA9FDD75 (media_id), PRIMARY KEY(product_id, media_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_video (product_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_DD9BA1704584665A (product_id), INDEX IDX_DD9BA17029C1004E (video_id), PRIMARY KEY(product_id, video_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE brand_audit');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE67D8904');
        $this->addSql('DROP INDEX IDX_D34A04ADE67D8904 ON product');
        $this->addSql('ALTER TABLE product DROP softwares_id, DROP subname');
        $this->addSql('ALTER TABLE product_audit DROP softwares_id, DROP subname');
    }
}
