# Use the latest MySQL image
# FROM docker.io/library/mysql:latest
#
# # Set environment variables
# ENV MYSQL_ROOT_PASSWORD=root
# ENV MYSQL_USER=symfony
# ENV MYSQL_PASSWORD=symfony
#
# # Copy initialization script
# COPY init-db.sql /docker-entrypoint-initdb.d/
#
# # Ensure correct permissions
# RUN chmod 644 /docker-entrypoint-initdb.d/init-db.sql
#
# CMD ["bash", "-c", "docker-entrypoint.sh mysqld & sleep 10 && mysql -h 127.0.0.1 -u root -p$MYSQL_ROOT_PASSWORD < /docker-entrypoint-initdb.d/init-db.sql && wait"]

FROM docker.io/library/mariadb:latest

ENV MARIADB_ROOT_PASSWORD=root
ENV MARIADB_USER=symfony
ENV MARIADB_PASSWORD=symfony

COPY init-db.sql /docker-entrypoint-initdb.d/
RUN chmod 644 /docker-entrypoint-initdb.d/init-db.sql

