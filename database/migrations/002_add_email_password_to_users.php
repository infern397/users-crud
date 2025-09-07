<?php
return <<<SQL
ALTER TABLE users
    ADD COLUMN email VARCHAR(255) NOT NULL UNIQUE AFTER full_name,
    ADD COLUMN password VARCHAR(255) NOT NULL AFTER email;
SQL;