<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017120653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournament_game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament_game_nb_joueur (tournament_game_id INT NOT NULL, nb_joueur_id INT NOT NULL, INDEX IDX_1EBCE8238F80220F (tournament_game_id), INDEX IDX_1EBCE823B5FA4887 (nb_joueur_id), PRIMARY KEY(tournament_game_id, nb_joueur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournament_game_nb_joueur ADD CONSTRAINT FK_1EBCE8238F80220F FOREIGN KEY (tournament_game_id) REFERENCES tournament_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournament_game_nb_joueur ADD CONSTRAINT FK_1EBCE823B5FA4887 FOREIGN KEY (nb_joueur_id) REFERENCES nb_joueur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD nb_player_id INT DEFAULT NULL, ADD tournament_game_id INT NOT NULL, DROP tournament_game');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C85FE6A34 FOREIGN KEY (nb_player_id) REFERENCES nb_joueur (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C8F80220F FOREIGN KEY (tournament_game_id) REFERENCES tournament_game (id)');
        $this->addSql('CREATE INDEX IDX_232B318C85FE6A34 ON game (nb_player_id)');
        $this->addSql('CREATE INDEX IDX_232B318C8F80220F ON game (tournament_game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C8F80220F');
        $this->addSql('ALTER TABLE tournament_game_nb_joueur DROP FOREIGN KEY FK_1EBCE8238F80220F');
        $this->addSql('ALTER TABLE tournament_game_nb_joueur DROP FOREIGN KEY FK_1EBCE823B5FA4887');
        $this->addSql('DROP TABLE tournament_game');
        $this->addSql('DROP TABLE tournament_game_nb_joueur');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C85FE6A34');
        $this->addSql('DROP INDEX IDX_232B318C85FE6A34 ON game');
        $this->addSql('DROP INDEX IDX_232B318C8F80220F ON game');
        $this->addSql('ALTER TABLE game ADD tournament_game TINYINT(1) DEFAULT NULL, DROP nb_player_id, DROP tournament_game_id');
    }
}
