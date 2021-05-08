<?php

declare(strict_types=1);

namespace Bot\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507204708 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE WowSpec (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE WowSpecTop (id INT AUTO_INCREMENT NOT NULL, spec_id INT DEFAULT NULL, rank INT NOT NULL, created_at INT NOT NULL, updated_at INT NOT NULL, INDEX IDX_2586FDB8AA8FA4FB (spec_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE WowSpecTop ADD CONSTRAINT FK_2586FDB8AA8FA4FB FOREIGN KEY (spec_id) REFERENCES WowSpec (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE WowSpecTop DROP FOREIGN KEY FK_2586FDB8AA8FA4FB');
        $this->addSql('DROP TABLE WowSpec');
        $this->addSql('DROP TABLE WowSpecTop');
    }
}
