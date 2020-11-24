<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124212240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bureau (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, universite_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, post VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, cv VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, specialite VARCHAR(255) NOT NULL, profil LONGTEXT NOT NULL, INDEX IDX_166FDEC4B3E9C81 (niveau_id), INDEX IDX_166FDEC42A52F05F (universite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bureau ADD CONSTRAINT FK_166FDEC4B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE bureau ADD CONSTRAINT FK_166FDEC42A52F05F FOREIGN KEY (universite_id) REFERENCES universite (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bureau');
    }
}
