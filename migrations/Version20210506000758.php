<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506000758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /* $this->addSql('ALTER TABLE class_school ALTER current_timetable DROP NOT NULL'); */
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT fk_fbce3e7ad2fd11');
        $this->addSql('DROP INDEX idx_fbce3e7ad2fd11');
        $this->addSql('ALTER TABLE subject DROP pupil_id');
        $this->addSql('ALTER TABLE subject DROP grades');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE class_school ALTER current_timetable SET NOT NULL');
        $this->addSql('ALTER TABLE subject ADD pupil_id INT NOT NULL');
        $this->addSql('ALTER TABLE subject ADD grades TEXT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN subject.grades IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT fk_fbce3e7ad2fd11 FOREIGN KEY (pupil_id) REFERENCES pupil (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fbce3e7ad2fd11 ON subject (pupil_id)');
    }
}
