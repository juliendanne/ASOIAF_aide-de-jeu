<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230608124206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE line_army_attachment (line_army_id INT NOT NULL, attachment_id INT NOT NULL, INDEX IDX_85DEF16AD76F54A (line_army_id), INDEX IDX_85DEF16464E68B (attachment_id), PRIMARY KEY(line_army_id, attachment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_army_attachment ADD CONSTRAINT FK_85DEF16AD76F54A FOREIGN KEY (line_army_id) REFERENCES line_army (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE line_army_attachment ADD CONSTRAINT FK_85DEF16464E68B FOREIGN KEY (attachment_id) REFERENCES attachment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_army_attachment DROP FOREIGN KEY FK_85DEF16AD76F54A');
        $this->addSql('ALTER TABLE line_army_attachment DROP FOREIGN KEY FK_85DEF16464E68B');
        $this->addSql('DROP TABLE line_army_attachment');
    }
}
