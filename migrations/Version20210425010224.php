<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425010224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pupil_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pupil (id INT NOT NULL, class_id INT NOT NULL, name VARCHAR(255) NOT NULL, phone_to_parents VARCHAR(9) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7DBD2B1EA000B10 ON pupil (class_id)');
        $this->addSql('ALTER TABLE pupil ADD CONSTRAINT FK_C7DBD2B1EA000B10 FOREIGN KEY (class_id) REFERENCES class_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pupil_id_seq CASCADE');
        $this->addSql('DROP TABLE pupil');
    }
}
