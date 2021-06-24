<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506005831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject ADD class_id INT');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7AEA000B10 FOREIGN KEY (class_id) REFERENCES class_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FBCE3E7AEA000B10 ON subject (class_id)');
        $this->addSql("UPDATE subject SET class_id=1");
        $this->addSql('ALTER TABLE subject ALTER class_id SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT FK_FBCE3E7AEA000B10');
        $this->addSql('DROP INDEX IDX_FBCE3E7AEA000B10');
        $this->addSql('ALTER TABLE subject DROP class_id');
    }
}
