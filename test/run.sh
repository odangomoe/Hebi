#!/usr/bin/env bash
set -e;

cd "$(realpath "$(dirname "$0")")/../"

truncate -s0 test/db.sqlite3;
composer dump-autoload;
./vendor/bin/propel model:build;
./vendor/bin/propel config:convert --config-dir test --output-file=test-config.php
./vendor/bin/propel sql:build --overwrite --config-dir test --output-dir test/data/sql;
./vendor/bin/propel sql:insert --config-dir test --sql-dir test/data/sql;
