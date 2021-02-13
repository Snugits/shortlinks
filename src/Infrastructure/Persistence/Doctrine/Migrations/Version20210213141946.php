<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213141946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates main table for storing shortcut links';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('create table short_links (
                        id int auto_increment
                        primary key,
                        alias    varchar(255) CHARACTER SET utf8 COLLATE utf8_bin not null,
                        url      varchar(255) not null,
                        constraint UNIQ_5187011D3EE4B093
                        unique (alias)
                    )
                    collate = utf8mb4_unicode_ci;
                    ');

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('short_links');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
