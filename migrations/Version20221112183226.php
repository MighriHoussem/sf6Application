<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221112183226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_hobby (person_id INT NOT NULL, hobby_id INT NOT NULL, INDEX IDX_9552ECF3217BBB47 (person_id), INDEX IDX_9552ECF3322B2123 (hobby_id), PRIMARY KEY(person_id, hobby_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, rs VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person_hobby ADD CONSTRAINT FK_9552ECF3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_hobby ADD CONSTRAINT FK_9552ECF3322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person ADD profil_id INT DEFAULT NULL, ADD person_job_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17697457E1F FOREIGN KEY (person_job_id) REFERENCES job (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD176275ED078 ON person (profil_id)');
        $this->addSql('CREATE INDEX IDX_34DCD17697457E1F ON person (person_job_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17697457E1F');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176275ED078');
        $this->addSql('ALTER TABLE person_hobby DROP FOREIGN KEY FK_9552ECF3217BBB47');
        $this->addSql('ALTER TABLE person_hobby DROP FOREIGN KEY FK_9552ECF3322B2123');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE person_hobby');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP INDEX UNIQ_34DCD176275ED078 ON person');
        $this->addSql('DROP INDEX IDX_34DCD17697457E1F ON person');
        $this->addSql('ALTER TABLE person DROP profil_id, DROP person_job_id');
    }
}
