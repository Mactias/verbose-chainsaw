<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210426162027 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /* $this->addSql('ALTER TABLE pupil ADD sex VARCHAR(10) NOT NULL'); */
        $this->addSql('ALTER TABLE pupil ADD sex VARCHAR(10) DEFAULT NULL');
        $this->addSql("UPDATE pupil SET sex = 'm'");
        $this->addSql('ALTER TABLE pupil ALTER COLUMN sex SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pupil DROP sex');
    }
}
