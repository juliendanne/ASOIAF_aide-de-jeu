<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626140538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_commander ADD army_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_commander ADD CONSTRAINT FK_F2D0E3C818D2742D FOREIGN KEY (army_id) REFERENCES army (id)');
        $this->addSql('CREATE INDEX IDX_F2D0E3C818D2742D ON line_commander (army_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_commander DROP FOREIGN KEY FK_F2D0E3C818D2742D');
        $this->addSql('DROP INDEX IDX_F2D0E3C818D2742D ON line_commander');
        $this->addSql('ALTER TABLE line_commander DROP army_id');
    }
}
