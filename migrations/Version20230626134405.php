<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626134405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE line_commander (id INT AUTO_INCREMENT NOT NULL, commander_id INT DEFAULT NULL, author_id INT DEFAULT NULL, link_line_army_id INT DEFAULT NULL, INDEX IDX_F2D0E3C83349A583 (commander_id), INDEX IDX_F2D0E3C8F675F31B (author_id), UNIQUE INDEX UNIQ_F2D0E3C85FD97588 (link_line_army_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_commander ADD CONSTRAINT FK_F2D0E3C83349A583 FOREIGN KEY (commander_id) REFERENCES commander (id)');
        $this->addSql('ALTER TABLE line_commander ADD CONSTRAINT FK_F2D0E3C8F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE line_commander ADD CONSTRAINT FK_F2D0E3C85FD97588 FOREIGN KEY (link_line_army_id) REFERENCES line_army (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_commander DROP FOREIGN KEY FK_F2D0E3C83349A583');
        $this->addSql('ALTER TABLE line_commander DROP FOREIGN KEY FK_F2D0E3C8F675F31B');
        $this->addSql('ALTER TABLE line_commander DROP FOREIGN KEY FK_F2D0E3C85FD97588');
        $this->addSql('DROP TABLE line_commander');
    }
}
