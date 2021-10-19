#!/bin/sh

SEPARATOPION='+++++++++++++++++++++++++++'
START_MESSAGE='start restore database dump.'
echo ${SEPARATOPION}
echo ${START_MESSAGE}

# dateコマンド結果を指定のフォーマットで出力
TIME_STAMP=$(date "+%Y%m%d_%H%M%S")

# CHANGE Variable.
DATABASE_CONTAINER_NAME=database_container_name
DATABASE_USER=database_user
DATABASE_NAME=database_name
DATABASE_PASSWORD=database_password
OUTPUT_FILE=sample/dump/dump.sql
# TIME_STAMPを使う場合
# OUTPUT_FILE=sample/dump/dump_${TIME_STAMP}.sql

# dump command.
docker exec -it ${DATABASE_CONTAINER_NAME} mysqldump -u ${DATABASE_USER} -p${DATABASE_PASSWORD} -D ${DATABASE_NAME} < ${OUTPUT_FILE}

# 現在のDocker コンテナの状態を出力
echo ${SEPARATOPION}
echo 'restore data base dump.'
echo ${SEPARATOPION}

