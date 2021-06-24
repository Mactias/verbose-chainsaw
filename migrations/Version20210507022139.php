<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507022139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE course_grades_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE course_grades (id INT NOT NULL, subject_id INT NOT NULL, pupil_id INT NOT NULL, grades TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94DBA05D23EDC87 ON course_grades (subject_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_94DBA05DD2FD11 ON course_grades (pupil_id)');
        $this->addSql('COMMENT ON COLUMN course_grades.grades IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE course_grades ADD CONSTRAINT FK_94DBA05D23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_grades ADD CONSTRAINT FK_94DBA05DD2FD11 FOREIGN KEY (pupil_id) REFERENCES pupil (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE course_grades_id_seq CASCADE');
        $this->addSql('DROP TABLE course_grades');
    }
}
