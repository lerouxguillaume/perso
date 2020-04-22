<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422210606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE daily_stats DROP FOREIGN KEY FK_D766067EA4AEAFEA');
        $this->addSql('ALTER TABLE time_serie DROP FOREIGN KEY FK_EF487248A4AEAFEA');
        $this->addSql('DROP TABLE daily_stats');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE time_serie');
        $this->addSql('ALTER TABLE image_of_the_day CHANGE url url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE daily_stats (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, day DATETIME NOT NULL, day_variance DOUBLE PRECISION NOT NULL, week_variance DOUBLE PRECISION NOT NULL, month_variance DOUBLE PRECISION NOT NULL, trimester_variance DOUBLE PRECISION NOT NULL, year_variance DOUBLE PRECISION NOT NULL, five_year_variance DOUBLE PRECISION DEFAULT NULL, ten_year_variance DOUBLE PRECISION DEFAULT NULL, indice_confiance DOUBLE PRECISION DEFAULT NULL, INDEX IDX_D766067EA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, raison_sociale VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, trading_location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE time_serie (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, timestamp INT NOT NULL, open DOUBLE PRECISION NOT NULL, close DOUBLE PRECISION NOT NULL, high DOUBLE PRECISION NOT NULL, low DOUBLE PRECISION NOT NULL, volume DOUBLE PRECISION NOT NULL, INDEX IDX_EF487248A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE daily_stats ADD CONSTRAINT FK_D766067EA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE time_serie ADD CONSTRAINT FK_EF487248A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE image_of_the_day CHANGE url url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
