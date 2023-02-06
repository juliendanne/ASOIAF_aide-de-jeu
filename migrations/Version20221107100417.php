<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221107100417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statut_player (id INT AUTO_INCREMENT NOT NULL, teams_id INT DEFAULT NULL, players_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_2F96DB31D6365F12 (teams_id), INDEX IDX_2F96DB31F1849495 (players_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statut_player ADD CONSTRAINT FK_2F96DB31D6365F12 FOREIGN KEY (teams_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE statut_player ADD CONSTRAINT FK_2F96DB31F1849495 FOREIGN KEY (players_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut_player DROP FOREIGN KEY FK_2F96DB31D6365F12');
        $this->addSql('ALTER TABLE statut_player DROP FOREIGN KEY FK_2F96DB31F1849495');
        $this->addSql('DROP TABLE statut_player');
    }
}
