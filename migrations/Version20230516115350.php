<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516115350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE army_combat_unit (army_id INT NOT NULL, combat_unit_id INT NOT NULL, INDEX IDX_B1179D3F18D2742D (army_id), INDEX IDX_B1179D3FCC7C2DCF (combat_unit_id), PRIMARY KEY(army_id, combat_unit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE army_combat_unit ADD CONSTRAINT FK_B1179D3F18D2742D FOREIGN KEY (army_id) REFERENCES army (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE army_combat_unit ADD CONSTRAINT FK_B1179D3FCC7C2DCF FOREIGN KEY (combat_unit_id) REFERENCES combat_unit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE army_combat_unit DROP FOREIGN KEY FK_B1179D3F18D2742D');
        $this->addSql('ALTER TABLE army_combat_unit DROP FOREIGN KEY FK_B1179D3FCC7C2DCF');
        $this->addSql('DROP TABLE army_combat_unit');
    }
}
