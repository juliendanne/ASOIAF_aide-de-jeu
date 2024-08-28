<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516101309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE combat_unit ADD army_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE combat_unit ADD CONSTRAINT FK_47715CCE18D2742D FOREIGN KEY (army_id) REFERENCES army (id)');
        $this->addSql('CREATE INDEX IDX_47715CCE18D2742D ON combat_unit (army_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE combat_unit DROP FOREIGN KEY FK_47715CCE18D2742D');
        $this->addSql('DROP INDEX IDX_47715CCE18D2742D ON combat_unit');
        $this->addSql('ALTER TABLE combat_unit DROP army_id');
    }
}
