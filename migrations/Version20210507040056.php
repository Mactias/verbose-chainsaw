<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507040056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_grades ADD pupil_id INT');
        $this->addSql('ALTER TABLE course_grades ADD CONSTRAINT FK_94DBA05DD2FD11 FOREIGN KEY (pupil_id) REFERENCES pupil (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_94DBA05DD2FD11 ON course_grades (pupil_id)');
        $this->addSql("UPDATE course_grades SET pupil_id=1");
        $this->addSql('ALTER TABLE course_grades ALTER pupil_id SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE course_grades DROP CONSTRAINT FK_94DBA05DD2FD11');
        $this->addSql('DROP INDEX IDX_94DBA05DD2FD11');
        $this->addSql('ALTER TABLE course_grades DROP pupil_id');
    }
}
