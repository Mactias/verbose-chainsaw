<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427210204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teacher DROP CONSTRAINT fk_b0f6a6d5208f64f1');
        $this->addSql('DROP INDEX uniq_b0f6a6d5208f64f1');
        $this->addSql('ALTER TABLE teacher RENAME COLUMN tutor_id TO aclass_id');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D522335530 FOREIGN KEY (aclass_id) REFERENCES class_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0F6A6D522335530 ON teacher (aclass_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE teacher DROP CONSTRAINT FK_B0F6A6D522335530');
        $this->addSql('DROP INDEX UNIQ_B0F6A6D522335530');
        $this->addSql('ALTER TABLE teacher RENAME COLUMN aclass_id TO tutor_id');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT fk_b0f6a6d5208f64f1 FOREIGN KEY (tutor_id) REFERENCES class_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_b0f6a6d5208f64f1 ON teacher (tutor_id)');
    }
}
