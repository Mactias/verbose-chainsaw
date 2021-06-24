<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507035639 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_grades DROP CONSTRAINT fk_94dba05dd2fd11');
        $this->addSql('DROP INDEX uniq_94dba05dd2fd11');
        $this->addSql('ALTER TABLE course_grades DROP pupil_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE course_grades ADD pupil_id INT NOT NULL');
        $this->addSql('ALTER TABLE course_grades ADD CONSTRAINT fk_94dba05dd2fd11 FOREIGN KEY (pupil_id) REFERENCES pupil (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_94dba05dd2fd11 ON course_grades (pupil_id)');
    }
}
