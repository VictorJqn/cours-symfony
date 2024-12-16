<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241216141344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DDE45DDE');
        $this->addSql('DROP INDEX IDX_8D93D649DDE45DDE ON user');
        $this->addSql('ALTER TABLE user DROP current_subscription_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `user` ADD current_subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649DDE45DDE FOREIGN KEY (current_subscription_id) REFERENCES subscription (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649DDE45DDE ON `user` (current_subscription_id)');
    }
}
