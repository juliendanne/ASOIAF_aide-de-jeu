<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019115927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, date DATE NOT NULL, author_is_player TINYINT(1) DEFAULT NULL, format VARCHAR(255) NOT NULL, tournament_game TINYINT(1) DEFAULT NULL, time TIME NOT NULL, nb_total_player INT DEFAULT NULL, nb_of_team INT DEFAULT NULL, address VARCHAR(255) NOT NULL, zip_code INT NOT NULL, city VARCHAR(255) NOT NULL, department VARCHAR(255) DEFAULT NULL, nb_of_game INT NOT NULL, game_statut VARCHAR(255) DEFAULT NULL, creation_date DATE DEFAULT NULL, modif_date DATE DEFAULT NULL, INDEX IDX_232B318CF675F31B (author_id), INDEX IDX_232B318C98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_user (game_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6686BA65E48FD905 (game_id), INDEX IDX_6686BA65A76ED395 (user_id), PRIMARY KEY(game_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, notif_author_id INT NOT NULL, game_id INT DEFAULT NULL, object VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, creation_date DATE DEFAULT NULL, modif_date DATE DEFAULT NULL, INDEX IDX_BF5476CA8D63432E (notif_author_id), INDEX IDX_BF5476CAE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_user (notification_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_35AF9D73EF1A9D84 (notification_id), INDEX IDX_35AF9D73A76ED395 (user_id), PRIMARY KEY(notification_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, region_statut TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, team_link_for_game_id INT DEFAULT NULL, team_statut TINYINT(1) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, creation_date DATE DEFAULT NULL, modif_date DATE DEFAULT NULL, INDEX IDX_C4E0A61FA2A4305A (team_link_for_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_user (team_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5C722232296CD8AE (team_id), INDEX IDX_5C722232A76ED395 (user_id), PRIMARY KEY(team_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_of_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, statut TINYINT(1) DEFAULT NULL, creation_date DATE DEFAULT NULL, modif_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA8D63432E FOREIGN KEY (notif_author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FA2A4305A FOREIGN KEY (team_link_for_game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE team_user ADD CONSTRAINT FK_5C722232296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_user ADD CONSTRAINT FK_5C722232A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF675F31B');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C98260155');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65E48FD905');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65A76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA8D63432E');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE48FD905');
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73EF1A9D84');
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73A76ED395');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FA2A4305A');
        $this->addSql('ALTER TABLE team_user DROP FOREIGN KEY FK_5C722232296CD8AE');
        $this->addSql('ALTER TABLE team_user DROP FOREIGN KEY FK_5C722232A76ED395');
        $this->addSql('DROP TABLE faction');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_user');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_user');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_user');
        $this->addSql('DROP TABLE type_of_unit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
