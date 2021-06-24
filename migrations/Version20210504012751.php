<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504012751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /* $this->addSql('ALTER TABLE class_school ADD all_subjects JSON NOT NULL'); */
        $this->addSql('ALTER TABLE class_school ADD all_subjects JSON');
        $this->addSql("UPDATE class_school SET all_subjects='{}'");
        $this->addSql('ALTER TABLE class_school ALTER COLUMN all_subjects SET NOT NULL');
        /* $this->addSql('ALTER TABLE class_school ALTER current_timetable DROP NOT NULL'); */
        $this->addSql('ALTER TABLE subject ALTER grades TYPE TEXT');
        $this->addSql('ALTER TABLE subject ALTER grades DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN subject.grades IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE class_school DROP all_subjects');
        $this->addSql('ALTER TABLE class_school ALTER current_timetable SET NOT NULL');
        $this->addSql('ALTER TABLE subject ALTER grades TYPE JSON');
        $this->addSql('ALTER TABLE subject ALTER grades DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN subject.grades IS NULL');
    }
}
