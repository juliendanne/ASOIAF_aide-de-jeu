<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508134441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE line_army (id INT AUTO_INCREMENT NOT NULL, army_id INT NOT NULL, combat_unit_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_876CDCEF18D2742D (army_id), INDEX IDX_876CDCEFCC7C2DCF (combat_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_army ADD CONSTRAINT FK_876CDCEF18D2742D FOREIGN KEY (army_id) REFERENCES army (id)');
        $this->addSql('ALTER TABLE line_army ADD CONSTRAINT FK_876CDCEFCC7C2DCF FOREIGN KEY (combat_unit_id) REFERENCES combat_unit (id)');
        $this->addSql('ALTER TABLE army ADD army_user_id INT NOT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE army ADD CONSTRAINT FK_C212F36A0711AF5 FOREIGN KEY (army_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C212F36A0711AF5 ON army (army_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_army DROP FOREIGN KEY FK_876CDCEF18D2742D');
        $this->addSql('ALTER TABLE line_army DROP FOREIGN KEY FK_876CDCEFCC7C2DCF');
        $this->addSql('DROP TABLE line_army');
        $this->addSql('ALTER TABLE army DROP FOREIGN KEY FK_C212F36A0711AF5');
        $this->addSql('DROP INDEX IDX_C212F36A0711AF5 ON army');
        $this->addSql('ALTER TABLE army DROP army_user_id, DROP status');
    }
}
