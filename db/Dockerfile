# db/Dockerfile
FROM mysql:8.0

# Copier le script d'initialisation
COPY init.sql /docker-entrypoint-initdb.d/

# Définir les variables d'environnement par défaut
ENV MYSQL_DATABASE=voteapp
ENV MYSQL_ROOT_PASSWORD=root_password
ENV MYSQL_USER=voteapp_user
ENV MYSQL_PASSWORD=voteapp_pass
