FROM mcr.microsoft.com/mssql/server

LABEL maintainer="Zack Higdon <zack.higdon@gmail.com>"

# Create config directory
# an set it as WORKDIR
RUN mkdir -p /usr/src
WORKDIR /usr/src

# Bundle app source
COPY . /usr/src

# RUN chmod +x /usr/src/create_table.sh

ENV MSSQL_DATABASE=$MSSQL_DATABASE
ENV ACCEPT_EULA=Y
ENV SA_PASSWORD=$MSSQL_PASSWORD
ENV MSSQL_PID = $MSSQL_DB_TYPE

VOLUME /var/opt/mssql

EXPOSE 1433

CMD sh -c ' chmod +x ./entrypoint.sh; ./entrypoint.sh & /opt/mssql/bin/sqlservr;'
