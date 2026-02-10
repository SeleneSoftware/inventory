#!/bin/bash
set -e

# Path to MariaDB data directory
DATADIR="/var/lib/mysql"

# Check if InnoDB log files are missing and recreate them if necessary
if [ ! -f "$DATADIR/ib_logfile0" ]; then
    echo "InnoDB log files missing, recreating..."
    rm -f "$DATADIR/ib_logfile*"  # Remove all log files
fi

# Initialize the database if it's the first run
if [ ! -d "$DATADIR/mysql" ]; then
    echo "Database not initialized, initializing..."
    mysqld --initialize-insecure --datadir="$DATADIR" --user=mysql
else
    echo "Database already initialized, skipping initialization."
fi

# Run upgrade if necessary
if [ "$MARIADB_AUTO_UPGRADE" = "1" ]; then
    echo "Running MariaDB upgrade..."
    mysql_upgrade --user=root --force || true
fi

# Start the MariaDB server
exec "$@"

