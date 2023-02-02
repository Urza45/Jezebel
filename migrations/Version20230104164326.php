<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104164326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E0376D43C268');
        //$this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037FB9F2563');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, _name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, login VARCHAR(10) NOT NULL, _password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, codeagence VARCHAR(11) DEFAULT \'CFP78\' NOT NULL, id_role INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        //$this->addSql('DROP TABLE users_old');
        //$this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E0376D43C268');
        //$this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037FB9F2563');
        //$this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E0376D43C268 FOREIGN KEY (id_formateur) REFERENCES users (id)');
        //$this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037FB9F2563 FOREIGN KEY (id_testeur) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037FB9F2563');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E0376D43C268');
        $this->addSql('CREATE TABLE users_old (id INT AUTO_INCREMENT NOT NULL, _name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, surname VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, login VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, _password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, email VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, phone VARCHAR(20) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, codeagence VARCHAR(11) CHARACTER SET utf8 DEFAULT \'CFP78\' NOT NULL COLLATE `utf8_general_ci`, id_role INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'Table utilisateurs\' ');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037FB9F2563');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E0376D43C268');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037FB9F2563 FOREIGN KEY (id_testeur) REFERENCES users_old (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E0376D43C268 FOREIGN KEY (id_formateur) REFERENCES users_old (id)');
    }
}
