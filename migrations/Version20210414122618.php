<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414122618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bureau (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, universite_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, cv VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, specialite VARCHAR(255) NOT NULL, profil LONGTEXT NOT NULL, INDEX IDX_166FDEC4B3E9C81 (niveau_id), INDEX IDX_166FDEC42A52F05F (universite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message MEDIUMTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, libelle MEDIUMTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, universite_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_anniversaire DATE NOT NULL, pays VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, cv VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, profil MEDIUMTEXT NOT NULL, telephone INT NOT NULL, specialite VARCHAR(255) NOT NULL, INDEX IDX_F6B4FB29B3E9C81 (niveau_id), INDEX IDX_F6B4FB292A52F05F (universite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_letter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentation (id INT AUTO_INCREMENT NOT NULL, libelle MEDIUMTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description MEDIUMTEXT NOT NULL, document VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL, date_creation DATE NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_50159CA9C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date_reunion DATE NOT NULL, heure_debut TIME NOT NULL, date_fin TIME NOT NULL, description LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, objet LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bureau ADD CONSTRAINT FK_166FDEC4B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE bureau ADD CONSTRAINT FK_166FDEC42A52F05F FOREIGN KEY (universite_id) REFERENCES universite (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB292A52F05F FOREIGN KEY (universite_id) REFERENCES universite (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9C54C8C93 FOREIGN KEY (type_id) REFERENCES genre (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9C54C8C93');
        $this->addSql('ALTER TABLE bureau DROP FOREIGN KEY FK_166FDEC4B3E9C81');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29B3E9C81');
        $this->addSql('ALTER TABLE bureau DROP FOREIGN KEY FK_166FDEC42A52F05F');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB292A52F05F');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE bureau');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE news_letter');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE presentation');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE reunion');
        $this->addSql('DROP TABLE universite');
    }
}
